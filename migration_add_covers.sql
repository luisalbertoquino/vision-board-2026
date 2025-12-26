-- Migración: Agregar tabla de portadas personalizadas
-- Ejecutar en servidores existentes

USE vboard26;

-- Crear tabla para portadas personalizadas
CREATE TABLE IF NOT EXISTS card_covers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL UNIQUE,
    image_url VARCHAR(500) NOT NULL,
    uploaded_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_card_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar portadas por defecto (Unsplash)
INSERT INTO card_covers (category, image_url) VALUES
('growth', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800'),
('work', 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?w=800'),
('books', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800'),
('health', 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=800'),
('finance', 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=800'),
('mobility', 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=800'),
('social', 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=800')
ON DUPLICATE KEY UPDATE category = category;
