#!/bin/bash

# Script de despliegue para Vision Board 2026
# Uso: sudo bash deploy.sh

set -e  # Salir si hay algún error

echo "========================================="
echo "  Vision Board 2026 - Deploy Script"
echo "========================================="
echo ""

# Variables de configuración
PROJECT_NAME="vision_board_2026"
REPO_URL="https://github.com/luisalbertoquino/vision-board-2026.git"
INSTALL_DIR="/var/www/$PROJECT_NAME"
BACKUP_DIR="/var/www/backups/$PROJECT_NAME"
TEMP_DIR="/tmp/$PROJECT_NAME"
WEB_USER="www-data"
WEB_GROUP="www-data"

# Credenciales de base de datos (asegúrate de que coincidan con setup_mysql.sh)
DB_HOST="localhost"
DB_NAME="vboard26"
DB_USER="vboard_user"
DB_PASS="VisionB0ard2026!Secure"

echo "Configuración:"
echo "  - Repositorio: https://github.com/luisalbertoquino/vision-board-2026.git"
echo "  - Directorio: $INSTALL_DIR"
echo "  - Usuario web: $WEB_USER"
echo ""

# Verificar si se está ejecutando como root
if [ "$EUID" -ne 0 ]; then
    echo "✗ Error: Este script debe ejecutarse como root (usa sudo)"
    exit 1
fi

# Paso 1: Crear backup si existe instalación previa
if [ -d "$INSTALL_DIR" ]; then
    echo "→ Creando backup de instalación anterior..."
    mkdir -p "$BACKUP_DIR"
    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    tar -czf "$BACKUP_DIR/backup_$TIMESTAMP.tar.gz" -C "$(dirname $INSTALL_DIR)" "$(basename $INSTALL_DIR)" 2>/dev/null || true
    echo "  ✓ Backup creado: backup_$TIMESTAMP.tar.gz"
fi

# Paso 2: Limpiar directorio temporal
echo ""
echo "→ Limpiando directorio temporal..."
rm -rf "$TEMP_DIR"
mkdir -p "$TEMP_DIR"

# Paso 3: Clonar el repositorio
echo ""
echo "→ Clonando repositorio desde GitHub..."
git clone "$REPO_URL" "$TEMP_DIR"
if [ $? -ne 0 ]; then
    echo "✗ Error al clonar el repositorio"
    exit 1
fi
echo "  ✓ Repositorio clonado exitosamente"

# Paso 4: Eliminar archivos innecesarios
echo ""
echo "→ Limpiando archivos innecesarios..."
rm -rf "$TEMP_DIR/.git"
rm -rf "$TEMP_DIR/.claude"
rm -f "$TEMP_DIR/.gitignore"
rm -f "$TEMP_DIR/setup_mysql.sh"
rm -f "$TEMP_DIR/deploy.sh"
echo "  ✓ Archivos de desarrollo eliminados"

# Paso 5: Crear/actualizar config.php con credenciales correctas
echo ""
echo "→ Configurando archivo de base de datos..."
cat > "$TEMP_DIR/config.php" <<'EOF'
<?php
/**
 * Configuración de Base de Datos - Vision Board 2026
 */

// Configuración de la base de datos
define('DB_HOST', 'DB_HOST_PLACEHOLDER');
define('DB_USER', 'DB_USER_PLACEHOLDER');
define('DB_PASS', 'DB_PASS_PLACEHOLDER');
define('DB_NAME', 'DB_NAME_PLACEHOLDER');
define('DB_CHARSET', 'utf8mb4');

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Función para obtener conexión a la base de datos
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        return null;
    }

    $conn->set_charset(DB_CHARSET);
    return $conn;
}

// Función para responder con JSON
function jsonResponse($success, $data = null, $message = '') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>
EOF

# Reemplazar placeholders con valores reales
sed -i "s/DB_HOST_PLACEHOLDER/$DB_HOST/g" "$TEMP_DIR/config.php"
sed -i "s/DB_USER_PLACEHOLDER/$DB_USER/g" "$TEMP_DIR/config.php"
sed -i "s/DB_PASS_PLACEHOLDER/$DB_PASS/g" "$TEMP_DIR/config.php"
sed -i "s/DB_NAME_PLACEHOLDER/$DB_NAME/g" "$TEMP_DIR/config.php"

echo "  ✓ Archivo config.php actualizado"

# Paso 6: Mover archivos al directorio de instalación
echo ""
echo "→ Instalando archivos en $INSTALL_DIR..."
mkdir -p "$INSTALL_DIR"
rm -rf "${INSTALL_DIR:?}"/*
cp -r "$TEMP_DIR/"* "$INSTALL_DIR/"
echo "  ✓ Archivos copiados exitosamente"

# Paso 7: Configurar permisos
echo ""
echo "→ Configurando permisos..."
chown -R $WEB_USER:$WEB_GROUP "$INSTALL_DIR"
find "$INSTALL_DIR" -type f -exec chmod 644 {} \;
find "$INSTALL_DIR" -type d -exec chmod 755 {} \;
chmod 640 "$INSTALL_DIR/config.php"
echo "  ✓ Permisos configurados"

# Paso 8: Verificar conexión a base de datos
echo ""
echo "→ Verificando conexión a base de datos..."
php -r "
\$conn = new mysqli('$DB_HOST', '$DB_USER', '$DB_PASS', '$DB_NAME');
if (\$conn->connect_error) {
    echo '✗ Error de conexión: ' . \$conn->connect_error . PHP_EOL;
    exit(1);
}
echo '  ✓ Conexión a base de datos exitosa' . PHP_EOL;
\$conn->close();
"

if [ $? -ne 0 ]; then
    echo ""
    echo "ADVERTENCIA: No se pudo conectar a la base de datos."
    echo "Asegúrate de ejecutar primero: sudo bash setup_mysql.sh"
    echo ""
fi

# Paso 8.5: Configurar carpeta de uploads
echo ""
echo "→ Configurando carpeta de uploads..."
mkdir -p "$INSTALL_DIR/uploads/covers"
chown -R $WEB_USER:$WEB_GROUP "$INSTALL_DIR/uploads"
chmod -R 755 "$INSTALL_DIR/uploads"
chmod -R 775 "$INSTALL_DIR/uploads/covers"
echo "  ✓ Carpeta de uploads configurada"

# Paso 9: Limpiar directorio temporal
echo ""
echo "→ Limpiando archivos temporales..."
rm -rf "$TEMP_DIR"
echo "  ✓ Limpieza completada"

# Paso 10: Información final
echo ""
echo "========================================="
echo "  ✓ Despliegue completado exitosamente"
echo "========================================="
echo ""
echo "Información del proyecto:"
echo "  - Directorio: $INSTALL_DIR"
echo "  - Dominio: luisalbertoquino.invite-art.com"
echo "  - Base de datos: $DB_NAME"
echo ""
echo "Próximos pasos:"
echo "  1. Configura LiteSpeed para apuntar a: $INSTALL_DIR"
echo "  2. Verifica que el dominio apunte correctamente"
echo "  3. Accede a: https://luisalbertoquino.invite-art.com"
echo ""
echo "Para actualizar el proyecto en el futuro:"
echo "  sudo bash /var/www/$PROJECT_NAME/deploy.sh"
echo ""
echo "Notas:"
echo "  - Backups guardados en: $BACKUP_DIR"
echo "  - Logs de PHP: /var/log/php/error.log"
echo "  - Logs de LiteSpeed: /usr/local/lsws/logs/"
echo ""
echo "========================================="
