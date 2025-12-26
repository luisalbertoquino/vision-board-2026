#!/bin/bash

# Script para configurar la base de datos MySQL para Vision Board 2026
# Uso: bash setup_mysql.sh

echo "==================================="
echo "Vision Board 2026 - MySQL Setup"
echo "==================================="

# Variables de configuración
DB_NAME="vboard26"
DB_USER="vboard_user"
DB_PASS="VisionB0ard2026!Secure"
DB_HOST="localhost"

echo ""
echo "Configurando base de datos..."
echo "Database: $DB_NAME"
echo "User: $DB_USER"
echo ""

# Solicitar contraseña de MySQL root
echo "Por favor ingresa la contraseña de MySQL root:"
read -s MYSQL_ROOT_PASS
echo ""

# Crear la base de datos y el usuario
mysql -u root -p"$MYSQL_ROOT_PASS" <<MYSQL_SCRIPT
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario y otorgar privilegios
CREATE USER IF NOT EXISTS '${DB_USER}'@'${DB_HOST}' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'${DB_HOST}';
FLUSH PRIVILEGES;

-- Seleccionar la base de datos
USE ${DB_NAME};

-- Crear tabla goal_progress
CREATE TABLE IF NOT EXISTS goal_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    goal_id VARCHAR(100) NOT NULL,
    goal_index INT NOT NULL,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_date DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_goal (goal_id, goal_index),
    INDEX idx_goal_id (goal_id),
    INDEX idx_completed (is_completed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla user_settings
CREATE TABLE IF NOT EXISTS user_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla activity_log
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    goal_id VARCHAR(100) NOT NULL,
    goal_index INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    action_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_goal (goal_id, goal_index),
    INDEX idx_date (action_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla evidences
CREATE TABLE IF NOT EXISTS evidences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    image_data LONGTEXT NOT NULL,
    uploaded_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_uploaded_date (uploaded_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar configuración inicial
INSERT INTO user_settings (setting_key, setting_value)
VALUES ('start_date', NOW())
ON DUPLICATE KEY UPDATE setting_value = setting_value;

MYSQL_SCRIPT

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Base de datos configurada exitosamente!"
    echo ""
    echo "==================================="
    echo "Credenciales de la base de datos:"
    echo "==================================="
    echo "Host: $DB_HOST"
    echo "Database: $DB_NAME"
    echo "User: $DB_USER"
    echo "Password: $DB_PASS"
    echo "==================================="
    echo ""
    echo "IMPORTANTE: Guarda estas credenciales de forma segura."
    echo "Actualiza el archivo config.php con estos datos."
    echo ""
else
    echo ""
    echo "✗ Error al configurar la base de datos"
    echo "Verifica que MySQL esté ejecutándose y que tengas permisos de root"
    exit 1
fi
