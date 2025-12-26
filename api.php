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
        default:
            jsonResponse(false, null, 'Acción no válida');
    }
}

// Obtener todo el progreso
function getAllProgress() {
    $conn = getConnection();
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
    
    closeConnection($conn);
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
    $is_completed = isset($input['is_completed']) ? (bool)$input['is_completed'] : true;
    
    $conn = getConnection();
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
        
        closeConnection($conn);
        jsonResponse(true, ['goal_id' => $goal_id, 'goal_index' => $goal_index, 'is_completed' => $is_completed]);
    } else {
        closeConnection($conn);
        jsonResponse(false, null, 'Error al actualizar el progreso');
    }
}

// Guardar todo el progreso de una vez (útil para migración)
function saveAllProgress() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['progress'])) {
        jsonResponse(false, null, 'Faltan datos de progreso');
    }
    
    $conn = getConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }
    
    $conn->begin_transaction();
    
    try {
        foreach ($input['progress'] as $goal_id => $indices) {
            foreach ($indices as $index => $completed) {
                $is_completed = (bool)$completed;
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
        closeConnection($conn);
        jsonResponse(true, null, 'Progreso guardado exitosamente');
    } catch (Exception $e) {
        $conn->rollback();
        closeConnection($conn);
        jsonResponse(false, null, 'Error al guardar el progreso: ' . $e->getMessage());
    }
}

// Obtener estadísticas
function getStats() {
    $conn = getConnection();
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
    
    closeConnection($conn);
    
    jsonResponse(true, [
        'total_points' => (int)$total,
        'completed_points' => (int)$completed,
        'categories' => $categories
    ]);
}

// Obtener fecha de inicio
function getStartDate() {
    $conn = getConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "SELECT setting_value FROM user_settings WHERE setting_key = 'start_date'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        closeConnection($conn);
        jsonResponse(true, ['start_date' => $row['setting_value']]);
    } else {
        closeConnection($conn);
        jsonResponse(false, null, 'Fecha de inicio no encontrada');
    }
}

// Obtener evidencias de una categoría
function getEvidences() {
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if (empty($category)) {
        jsonResponse(false, null, 'Categoría no especificada');
    }

    $conn = getConnection();
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

    closeConnection($conn);
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

    $conn = getConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "INSERT INTO evidences (category, image_data) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        closeConnection($conn);
        jsonResponse(false, null, 'Error al preparar consulta: ' . $conn->error);
    }

    $stmt->bind_param("ss", $category, $image_data);

    if ($stmt->execute()) {
        $evidence_id = $conn->insert_id;
        closeConnection($conn);
        jsonResponse(true, ['id' => $evidence_id], 'Evidencia guardada exitosamente');
    } else {
        $error = $stmt->error;
        closeConnection($conn);
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

    $conn = getConnection();
    if (!$conn) {
        jsonResponse(false, null, 'Error de conexión a la base de datos');
    }

    $sql = "DELETE FROM evidences WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evidence_id);

    if ($stmt->execute()) {
        closeConnection($conn);
        jsonResponse(true, null, 'Evidencia eliminada exitosamente');
    } else {
        closeConnection($conn);
        jsonResponse(false, null, 'Error al eliminar la evidencia');
    }
}
?>
