# Instrucciones de Despliegue - Vision Board 2026
## Digital Ocean + Ubuntu + MySQL + LiteSpeed

---

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener:
- ✅ Droplet de Digital Ocean con Ubuntu
- ✅ MySQL instalado y ejecutándose
- ✅ LiteSpeed Web Server configurado
- ✅ Acceso SSH al servidor
- ✅ Subdominio configurado: `luisalbertoquino.invite-art.com`
- ✅ Git instalado en el servidor

---

## 🚀 Instalación Inicial (Primera vez)

### Paso 1: Conectarse al servidor
```bash
ssh root@tu-ip-del-droplet
# O si usas un usuario diferente:
ssh tuUsuario@tu-ip-del-droplet
```

### Paso 2: Instalar dependencias (si no están instaladas)
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Git si no está instalado
sudo apt install git -y

# Verificar MySQL
sudo systemctl status mysql

# Si MySQL no está instalado:
sudo apt install mysql-server -y
```

### Paso 3: Descargar los scripts de configuración
```bash
# Crear directorio temporal
cd /tmp

# Clonar el repositorio
git clone https://github.com/luisalbertoquino/vision-board-2026.git

# Entrar al directorio
cd vision-board-2026
```

### Paso 4: Configurar la base de datos
```bash
# Ejecutar script de configuración de MySQL
sudo bash setup_mysql.sh
```

**Credenciales generadas:**
- **Database:** vboard26
- **User:** vboard_user
- **Password:** VisionB0ard2026!Secure
- **Host:** localhost

> ⚠️ **IMPORTANTE:** Guarda estas credenciales de forma segura.

### Paso 5: Ejecutar el script de despliegue
```bash
# Ejecutar deploy
sudo bash deploy.sh
```

Este script:
1. ✅ Crea backup de instalación anterior (si existe)
2. ✅ Clona el repositorio desde GitHub
3. ✅ Configura el archivo `config.php` con las credenciales de BD
4. ✅ Copia archivos a `/var/www/vision_board_2026`
5. ✅ Configura permisos correctos para www-data
6. ✅ Verifica conexión a base de datos

### Paso 6: Configurar LiteSpeed

#### Opción A: Configuración manual en WebAdmin
1. Accede a LiteSpeed WebAdmin: `https://tu-ip:7080`
2. Ve a **Virtual Hosts** → **Add**
3. Configura:
   - **Virtual Host Name:** vision_board_2026
   - **Virtual Host Root:** `/var/www/vision_board_2026/`
   - **Config File:** `/usr/local/lsws/conf/vhosts/vision_board_2026/vhconf.conf`
   - **Document Root:** `/var/www/vision_board_2026/`
   - **Domain Name:** `luisalbertoquino.invite-art.com`
   - **Index Files:** `index.php, index.html`

#### Opción B: Configuración por CLI
```bash
# Crear directorio de configuración
sudo mkdir -p /usr/local/lsws/conf/vhosts/vision_board_2026

# Crear archivo de configuración
sudo nano /usr/local/lsws/conf/vhosts/vision_board_2026/vhconf.conf
```

Pega esta configuración:
```apache
docRoot                   /var/www/vision_board_2026
enableGzip                1

index  {
  useServer               0
  indexFiles              index.php, index.html
}

scripthandler  {
  add lsapi:lsphp74 php
}

rewrite  {
  enable                  1
  autoLoadHtaccess        1
}
```

Luego reinicia LiteSpeed:
```bash
sudo /usr/local/lsws/bin/lswsctrl restart
```

### Paso 7: Verificar instalación
```bash
# Verificar archivos
ls -la /var/www/vision_board_2026

# Verificar permisos
ls -l /var/www/vision_board_2026/config.php

# Probar conexión PHP-MySQL
php -r "
\$conn = new mysqli('localhost', 'vboard_user', 'VisionB0ard2026!Secure', 'vboard26');
if (\$conn->connect_error) {
    echo 'Error: ' . \$conn->connect_error;
} else {
    echo 'Conexión exitosa a MySQL';
}
"
```

### Paso 8: Acceder a la aplicación
Abre tu navegador y ve a:
```
https://luisalbertoquino.invite-art.com
```

---

## 🔄 Actualizar el Proyecto (Despliegue futuro)

Cuando hagas cambios en el código y quieras desplegarlos:

### Método 1: Ejecutar script desde GitHub
```bash
# Conectarse al servidor
ssh root@tu-ip-del-droplet

# Descargar y ejecutar script actualizado
cd /tmp
rm -rf vision-board-2026
git clone https://github.com/luisalbertoquino/vision-board-2026.git
cd vision-board-2026
sudo bash deploy.sh
```

### Método 2: Mantener script en el servidor
```bash
# Si guardaste el script en el servidor
ssh root@tu-ip-del-droplet
sudo bash /var/www/vision_board_2026/deploy.sh
```

> ⚠️ **NOTA:** El script crea backups automáticos en `/var/www/backups/vision_board_2026/`

---

## 🔧 Configuración PHP (si es necesario)

Si tienes problemas con tamaño de archivos o timeouts:

```bash
# Editar configuración PHP
sudo nano /usr/local/lsws/lsphp74/etc/php/7.4/litespeed/php.ini

# Modificar estos valores:
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
max_input_time = 300
memory_limit = 128M

# Reiniciar LiteSpeed
sudo /usr/local/lsws/bin/lswsctrl restart
```

---

## 🗄️ Gestión de Base de Datos

### Acceder a MySQL
```bash
mysql -u vboard_user -p vboard26
# Password: VisionB0ard2026!Secure
```

### Ver tablas
```sql
SHOW TABLES;
```

### Ver progreso guardado
```sql
SELECT * FROM goal_progress;
```

### Ver evidencias
```sql
SELECT id, category, uploaded_date FROM evidences;
```

### Backup de base de datos
```bash
# Crear backup
mysqldump -u vboard_user -p vboard26 > backup_$(date +%Y%m%d).sql

# Restaurar backup
mysql -u vboard_user -p vboard26 < backup_20260126.sql
```

---

## 📊 Monitoreo y Logs

### Ver logs de PHP
```bash
sudo tail -f /var/log/php/error.log
```

### Ver logs de LiteSpeed
```bash
sudo tail -f /usr/local/lsws/logs/error.log
```

### Ver logs de acceso
```bash
sudo tail -f /usr/local/lsws/logs/access.log
```

---

## 🐛 Solución de Problemas

### Error 500 - Internal Server Error
```bash
# Verificar logs de error
sudo tail -50 /usr/local/lsws/logs/error.log

# Verificar permisos
sudo chown -R www-data:www-data /var/www/vision_board_2026
sudo chmod 640 /var/www/vision_board_2026/config.php
```

### No se guardan los datos
```bash
# Verificar conexión a MySQL
php -r "\$c = new mysqli('localhost', 'vboard_user', 'VisionB0ard2026!Secure', 'vboard26'); echo \$c->connect_error ? 'Error' : 'OK';"

# Verificar que las tablas existen
mysql -u vboard_user -p vboard26 -e "SHOW TABLES;"
```

### Las imágenes no se suben
```bash
# Verificar configuración PHP
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Verificar permisos de escritura
ls -la /var/www/vision_board_2026
```

---

## 🔐 Seguridad

### Cambiar contraseña de base de datos
```bash
mysql -u root -p
```

```sql
ALTER USER 'vboard_user'@'localhost' IDENTIFIED BY 'NuevaPasswordSegura123!';
FLUSH PRIVILEGES;
```

Luego actualiza `config.php`:
```bash
sudo nano /var/www/vision_board_2026/config.php
# Actualiza DB_PASS con la nueva contraseña
```

### Firewall
```bash
# Verificar firewall
sudo ufw status

# Permitir HTTP y HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
```

---

## 📝 Estructura de Archivos en Servidor

```
/var/www/vision_board_2026/
├── index.php              # Aplicación principal
├── api.php                # API REST
├── config.php             # Configuración DB (640 permisos)
├── setup_database.sql     # Schema de DB
├── README.md              # Documentación
└── .htaccess              # Configuración PHP

/var/www/backups/vision_board_2026/
└── backup_20260126_143022.tar.gz  # Backups automáticos
```

---

## ✅ Checklist Post-Instalación

- [ ] Base de datos creada y configurada
- [ ] Archivos desplegados en `/var/www/vision_board_2026`
- [ ] Permisos configurados correctamente
- [ ] LiteSpeed apuntando al directorio correcto
- [ ] Dominio `luisalbertoquino.invite-art.com` funcionando
- [ ] Conexión a base de datos exitosa
- [ ] Puedes hacer clic en los puntos y se guardan
- [ ] Puedes subir imágenes de evidencias
- [ ] Confetti aparece al completar tareas
- [ ] SSL/HTTPS funcionando

---

## 📞 Comandos Útiles Rápidos

```bash
# Actualizar proyecto
sudo bash /var/www/vision_board_2026/deploy.sh

# Ver logs en tiempo real
sudo tail -f /usr/local/lsws/logs/error.log

# Reiniciar LiteSpeed
sudo /usr/local/lsws/bin/lswsctrl restart

# Backup de BD
mysqldump -u vboard_user -p vboard26 > backup.sql

# Verificar espacio en disco
df -h

# Ver procesos PHP
ps aux | grep php
```

---

**¡Listo!** Tu Vision Board 2026 está corriendo en producción 🚀

Para soporte: revisa los logs y la documentación técnica en el repositorio.
