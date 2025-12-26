#!/bin/bash

# Script para crear carpeta de uploads y configurar permisos
# Uso: sudo bash setup_uploads.sh

echo "========================================="
echo "  Setup Uploads Directory"
echo "========================================="
echo ""

PROJECT_DIR="/var/www/vision_board_2026"
UPLOADS_DIR="$PROJECT_DIR/uploads"
COVERS_DIR="$UPLOADS_DIR/covers"
WEB_USER="www-data"
WEB_GROUP="www-data"

# Verificar si se está ejecutando como root
if [ "$EUID" -ne 0 ]; then
    echo "✗ Error: Este script debe ejecutarse como root (usa sudo)"
    exit 1
fi

# Crear directorios
echo "→ Creando directorios de uploads..."
mkdir -p "$COVERS_DIR"

# Configurar permisos
echo "→ Configurando permisos..."
chown -R $WEB_USER:$WEB_GROUP "$UPLOADS_DIR"
chmod -R 755 "$UPLOADS_DIR"
chmod -R 775 "$COVERS_DIR"

# Crear archivo .htaccess para seguridad
cat > "$UPLOADS_DIR/.htaccess" << 'HTACCESS'
# Permitir solo imágenes
<FilesMatch "\.(jpg|jpeg|png|gif|webp)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Denegar acceso a cualquier otro tipo de archivo
<FilesMatch "\.">
    Order Allow,Deny
    Deny from all
</FilesMatch>
HTACCESS

chmod 644 "$UPLOADS_DIR/.htaccess"
chown $WEB_USER:$WEB_GROUP "$UPLOADS_DIR/.htaccess"

echo ""
echo "✓ Directorios creados exitosamente:"
echo "  - $UPLOADS_DIR"
echo "  - $COVERS_DIR"
echo ""
echo "✓ Permisos configurados:"
echo "  - Owner: $WEB_USER:$WEB_GROUP"
echo "  - Uploads: 755"
echo "  - Covers: 775"
echo ""
echo "✓ Seguridad configurada (.htaccess)"
echo ""
echo "========================================="
