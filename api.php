<?php
// api.php - API para manejar el progreso de objetivos

// Deshabilitar display de errores para evitar salida HTML
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once 'config.php';

// Configurar headers CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Obtener método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Obtener acción de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Manejar solicitudes según el método y acción
switch ($method) {
    case 'GET':
        handleGet($action);
        break;
    case 'POST':
        handlePost($action);
        break;
    default:
        jsonResponse(false, null, 'Método no permitido');
}

// Manejar solicitudes GET
function handleGet($action) {
    switch ($action) {
        case 'get_all_progress':
            getAllProgress();
            break;
        case 'get_stats':
            getStats();
            break;
        case 'get_start_date':
            getStartDate();
            break;
        case 'get_evidences':
            getEvidences();
            break;
        case 'get_cover':
            getCover();
            break;
        case 'get_all_covers':
            getAllCovers();
            break;
        default:
            jsonResponse(false, null, 'Acción no válida');
    }
}

// Manejar solicitudes POST
function handlePost($action) {
    switch ($action) {
        case 'toggle_progress':
            toggleProgress();
            break;
        case 'save_all_progress':
            saveAllProgress();
            break;
        case 'upload_evidence':
            uploadEvidence();
            break;
        case 'delete_evidence':
            deleteEvidence();
            break;
        case 'upload_cover':
            uploadCover();
            break;
        case 'delete_cover':
            deleteCover();
            break;
        default:
            jsonResponse(false, null, 'Acción no válida');
    }
}

// Obtener todo el progreso
function getAllProgress() {
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }
    
    $sql = "SELECT goal_id, goal_index, is_completed, completed_date FROM goal_progress";
    $result = $conn->query($sql);
    
    $progress = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!isset($progress[$row['goal_id']])) {
                $progress[$row['goal_id']] = [];
            }
            $progress[$row['goal_id']][$row['goal_index']] = [
                'completed' => (bool)$row['is_completed'],
                'date' => $row['completed_date']
            ];
        }
    }
    
    $conn->close();
    jsonResponse(true, $progress);
}

// Alternar el progreso de un objetivo específico
function toggleProgress() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['goal_id']) || !isset($input['goal_index'])) {
        jsonResponse(false, null, 'Faltan parámetros requeridos');
    }
    
    $goal_id = $input['goal_id'];
    $goal_index = (int)$input['goal_index'];
    $is_completed = isset($input['is_completed']) ? (int)(bool)$input['is_completed'] : 1;
    
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }
    
    // Verificar si existe el registro
    $check_sql = "SELECT is_completed FROM goal_progress WHERE goal_id = ? AND goal_index = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("si", $goal_id, $goal_index);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Actualizar registro existente
        $completed_date = $is_completed ? date('Y-m-d H:i:s') : null;
        $update_sql = "UPDATE goal_progress SET is_completed = ?, completed_date = ? WHERE goal_id = ? AND goal_index = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("issi", $is_completed, $completed_date, $goal_id, $goal_index);
    } else {
        // Insertar nuevo registro
        $completed_date = $is_completed ? date('Y-m-d H:i:s') : null;
        $insert_sql = "INSERT INTO goal_progress (goal_id, goal_index, is_completed, completed_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("siis", $goal_id, $goal_index, $is_completed, $completed_date);
    }
    
    if ($stmt->execute()) {
        // Registrar en log de actividad
        $action = $is_completed ? 'completed' : 'uncompleted';
        $log_sql = "INSERT INTO activity_log (goal_id, goal_index, action) VALUES (?, ?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("sis", $goal_id, $goal_index, $action);
        $log_stmt->execute();
        
        $conn->close();
        jsonResponse(true, ['goal_id' => $goal_id, 'goal_index' => $goal_index, 'is_completed' => $is_completed]);
    } else {
        $conn->close();
        jsonResponse(false, null, 'Error al actualizar el progreso');
    }
}

// Guardar todo el progreso de una vez (útil para migración)
function saveAllProgress() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['progress'])) {
        jsonResponse(false, null, 'Faltan datos de progreso');
    }
    
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }
    
    $conn->begin_transaction();
    
    try {
        foreach ($input['progress'] as $goal_id => $indices) {
            foreach ($indices as $index => $completed) {
                $is_completed = (int)(bool)$completed;
                $completed_date = $is_completed ? date('Y-m-d H:i:s') : null;
                
                $sql = "INSERT INTO goal_progress (goal_id, goal_index, is_completed, completed_date) 
                        VALUES (?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE is_completed = ?, completed_date = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siisis", $goal_id, $index, $is_completed, $completed_date, $is_completed, $completed_date);
                $stmt->execute();
            }
        }
        
        $conn->commit();
        $conn->close();
        jsonResponse(true, null, 'Progreso guardado exitosamente');
    } catch (Exception $e) {
        $conn->rollback();
        $conn->close();
        jsonResponse(false, null, 'Error al guardar el progreso: ' . $e->getMessage());
    }
}

// Obtener estadísticas
function getStats() {
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }
    
    // Total de puntos completados
    $completed_sql = "SELECT COUNT(*) as total FROM goal_progress WHERE is_completed = 1";
    $result = $conn->query($completed_sql);
    $completed = $result->fetch_assoc()['total'];
    
    // Total de puntos registrados
    $total_sql = "SELECT COUNT(*) as total FROM goal_progress";
    $result = $conn->query($total_sql);
    $total = $result->fetch_assoc()['total'];
    
    // Actividad por categoría
    $category_sql = "SELECT 
        SUBSTRING_INDEX(goal_id, '-', 1) as category,
        COUNT(*) as total,
        SUM(CASE WHEN is_completed = 1 THEN 1 ELSE 0 END) as completed
        FROM goal_progress
        GROUP BY category";
    $result = $conn->query($category_sql);
    
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[$row['category']] = [
            'total' => (int)$row['total'],
            'completed' => (int)$row['completed']
        ];
    }
    
    $conn->close();
    
    jsonResponse(true, [
        'total_points' => (int)$total,
        'completed_points' => (int)$completed,
        'categories' => $categories
    ]);
}

// Obtener fecha de inicio
function getStartDate() {
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT setting_value FROM user_settings WHERE setting_key = 'start_date'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $conn->close();
        jsonResponse(true, ['start_date' => $row['setting_value']]);
    } else {
        $conn->close();
        jsonResponse(false, null, 'Fecha de inicio no encontrada');
    }
}

// Obtener evidencias de una categoría
function getEvidences() {
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if (empty($category)) {
        jsonResponse(false, null, 'Categoría no especificada');
    }

    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT id, image_data, uploaded_date FROM evidences WHERE category = ? ORDER BY uploaded_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $evidences = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $evidences[] = [
                'id' => (int)$row['id'],
                'image' => $row['image_data'],
                'date' => $row['uploaded_date']
            ];
        }
    }

    $conn->close();
    jsonResponse(true, $evidences);
}

// Subir una evidencia
function uploadEvidence() {
    // Obtener el contenido raw
    $raw_input = file_get_contents('php://input');

    if (empty($raw_input)) {
        jsonResponse(false, null, 'No se recibieron datos');
    }

    $input = json_decode($raw_input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        jsonResponse(false, null, 'Error al decodificar JSON: ' . json_last_error_msg());
    }

    if (!isset($input['category']) || !isset($input['image_data'])) {
        jsonResponse(false, null, 'Faltan parámetros requeridos (category o image_data)');
    }

    $category = $input['category'];
    $image_data = $input['image_data'];

    // Validar que sea una imagen base64 válida
    if (!preg_match('/^data:image\/(png|jpg|jpeg|gif|webp);base64,/', $image_data)) {
        jsonResponse(false, null, 'Formato de imagen inválido');
    }

    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "INSERT INTO evidences (category, image_data) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $conn->close();
        jsonResponse(false, null, 'Error al preparar consulta: ' . $conn->error);
    }

    $stmt->bind_param("ss", $category, $image_data);

    if ($stmt->execute()) {
        $evidence_id = $conn->insert_id;
        $conn->close();
        jsonResponse(true, ['id' => $evidence_id], 'Evidencia guardada exitosamente');
    } else {
        $error = $stmt->error;
        $conn->close();
        jsonResponse(false, null, 'Error al guardar la evidencia: ' . $error);
    }
}

// Eliminar una evidencia
function deleteEvidence() {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id'])) {
        jsonResponse(false, null, 'ID de evidencia no especificado');
    }

    $evidence_id = (int)$input['id'];

    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "DELETE FROM evidences WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evidence_id);

    if ($stmt->execute()) {
        $conn->close();
        jsonResponse(true, null, 'Evidencia eliminada exitosamente');
    } else {
        $conn->close();
        jsonResponse(false, null, 'Error al eliminar la evidencia');
    }
}

// Obtener portada de una categoría
function getCover() {
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if (empty($category)) {
        jsonResponse(false, null, 'Categoría no especificada');
    }

    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT image_url FROM card_covers WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $conn->close();
        jsonResponse(true, ['image_url' => $row['image_url']]);
    } else {
        $conn->close();
        jsonResponse(false, null, 'Portada no encontrada');
    }
}

// Obtener todas las portadas
function getAllCovers() {
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT category, image_url FROM card_covers";
    $result = $conn->query($sql);

    $covers = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $covers[$row['category']] = $row['image_url'];
        }
    }

    $conn->close();
    jsonResponse(true, $covers);
}

// Subir una portada personalizada
function uploadCover() {
    // Verificar que se haya enviado un archivo
    if (!isset($_FILES['cover_image'])) {
        jsonResponse(false, null, 'No se recibió ningún archivo');
    }

    // Verificar que se haya enviado la categoría
    if (!isset($_POST['category'])) {
        jsonResponse(false, null, 'Categoría no especificada');
    }

    $category = $_POST['category'];
    $file = $_FILES['cover_image'];

    // Validar categorías permitidas
    $allowed_categories = ['growth', 'work', 'books', 'health', 'finance', 'mobility', 'social'];
    if (!in_array($category, $allowed_categories)) {
        jsonResponse(false, null, 'Categoría no válida');
    }

    // Validar el archivo
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        jsonResponse(false, null, 'Tipo de archivo no permitido. Use JPG, PNG, GIF o WEBP');
    }

    if ($file['size'] > $max_size) {
        jsonResponse(false, null, 'El archivo es demasiado grande. Máximo 5MB');
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        jsonResponse(false, null, 'Error al subir el archivo: ' . $file['error']);
    }

    // Crear directorio si no existe
    $upload_dir = __DIR__ . '/uploads/covers/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }

    // Eliminar portada anterior si existe
    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT image_url FROM card_covers WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $old_url = $row['image_url'];

        // Solo eliminar si no es una URL de Unsplash
        if (strpos($old_url, 'unsplash.com') === false && strpos($old_url, 'uploads/covers/') !== false) {
            $old_file = __DIR__ . '/' . $old_url;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }
    }

    // Generar nombre único para el archivo
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $category . '_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    $relative_url = 'uploads/covers/' . $filename;

    // Mover el archivo al directorio de uploads
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        $conn->close();
        jsonResponse(false, null, 'Error al guardar el archivo');
    }

    // Guardar la URL en la base de datos
    $sql = "INSERT INTO card_covers (category, image_url) VALUES (?, ?)
            ON DUPLICATE KEY UPDATE image_url = ?, updated_at = CURRENT_TIMESTAMP";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $category, $relative_url, $relative_url);

    if ($stmt->execute()) {
        $conn->close();
        jsonResponse(true, [
            'category' => $category,
            'image_url' => $relative_url
        ], 'Portada actualizada exitosamente');
    } else {
        // Si falla la BD, eliminar el archivo subido
        unlink($filepath);
        $conn->close();
        jsonResponse(false, null, 'Error al guardar la portada en la base de datos');
    }
}

// Eliminar una portada personalizada (restaurar a default)
function deleteCover() {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['category'])) {
        jsonResponse(false, null, 'Categoría no especificada');
    }

    $category = $input['category'];

    // URLs por defecto de Unsplash
    $default_covers = [
        'growth' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800',
        'work' => 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?w=800',
        'books' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800',
        'health' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=800',
        'finance' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=800',
        'mobility' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=800',
        'social' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=800'
    ];

    if (!isset($default_covers[$category])) {
        jsonResponse(false, null, 'Categoría no válida');
    }

    $conn = getDBConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    // Obtener URL actual para eliminar el archivo
    $sql = "SELECT image_url FROM card_covers WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_url = $row['image_url'];

        // Solo eliminar si no es una URL de Unsplash
        if (strpos($current_url, 'unsplash.com') === false && strpos($current_url, 'uploads/covers/') !== false) {
            $file_path = __DIR__ . '/' . $current_url;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }

    // Restaurar a la URL por defecto
    $default_url = $default_covers[$category];
    $sql = "UPDATE card_covers SET image_url = ?, updated_at = CURRENT_TIMESTAMP WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $default_url, $category);

    if ($stmt->execute()) {
        $conn->close();
        jsonResponse(true, [
            'category' => $category,
            'image_url' => $default_url
        ], 'Portada restaurada a la imagen por defecto');
    } else {
        $conn->close();
        jsonResponse(false, null, 'Error al restaurar la portada');
    }
}
?>
