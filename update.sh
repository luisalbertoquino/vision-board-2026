#!/bin/bash

# Script de actualización rápida para Vision Board 2026
# Uso: sudo bash update.sh

echo "========================================="
echo "  Vision Board 2026 - Quick Update"
echo "========================================="
echo ""

# Verificar si se está ejecutando como root
if [ "$EUID" -ne 0 ]; then
    echo "✗ Error: Este script debe ejecutarse como root (usa sudo)"
    exit 1
fi

# Limpiar y clonar
echo "→ Descargando última versión desde GitHub..."
cd /tmp
rm -rf vision-board-2026
git clone https://github.com/luisalbertoquino/vision-board-2026.git
cd vision-board-2026

# Ejecutar deploy
echo ""
echo "→ Desplegando actualización..."
bash deploy.sh

echo ""
echo "========================================="
echo "  ✓ Actualización completada"
echo "========================================="
echo ""
echo "Accede a: https://luisalbertoquino.invite-art.com"
echo ""
