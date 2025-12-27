-- Script para actualizar la tabla card_covers con la categoría 'social'
-- Ejecutar en el servidor de producción

USE vboard26;

-- Insertar portada para 'social' si no existe
INSERT INTO card_covers (category, image_url) VALUES
('social', 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=800')
ON DUPLICATE KEY UPDATE
    image_url = IF(image_url LIKE '%unsplash%', 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=800', image_url);

-- Verificar todas las categorías
SELECT category, image_url FROM card_covers ORDER BY category;
