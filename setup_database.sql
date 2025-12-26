-- Base de datos para Vision Board 2026
-- Usuario: root, Sin contraseña, Base de datos: vboard26

USE vboard26;

-- Tabla para almacenar el progreso de objetivos
CREATE TABLE IF NOT EXISTS goal_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    goal_id VARCHAR(50) NOT NULL,
    goal_index INT NOT NULL,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_goal (goal_id, goal_index)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para almacenar información del usuario y fecha de inicio
CREATE TABLE IF NOT EXISTS user_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar fecha de inicio si no existe
INSERT INTO user_settings (setting_key, setting_value) 
VALUES ('start_date', NOW())
ON DUPLICATE KEY UPDATE setting_key = setting_key;

-- Tabla para registro de actividad (opcional, para estadísticas)
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    goal_id VARCHAR(50) NOT NULL,
    goal_index INT NOT NULL,
    action VARCHAR(20) NOT NULL, -- 'completed' o 'uncompleted'
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para almacenar evidencias de logros
CREATE TABLE IF NOT EXISTS evidences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    image_data LONGTEXT NOT NULL,
    uploaded_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para mejor rendimiento
CREATE INDEX idx_goal_id ON goal_progress(goal_id);
CREATE INDEX idx_completed ON goal_progress(is_completed);
CREATE INDEX idx_activity_date ON activity_log(action_date);
CREATE INDEX idx_category ON evidences(category);
CREATE INDEX idx_uploaded_date ON evidences(uploaded_date);
