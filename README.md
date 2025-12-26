# Vision Board 2026 - Instrucciones de Instalación

## Requisitos
- Laragon (o XAMPP/WAMP) con PHP y MySQL
- Navegador web moderno

## Estructura de Archivos
```
vision_board_2026/
├── index.php           # Página principal del Vision Board
├── config.php          # Configuración de base de datos
├── api.php             # API para operaciones CRUD
├── setup_database.sql  # Script de creación de base de datos
└── README.md           # Este archivo
```

## Pasos de Instalación

### 1. Configurar la Carpeta del Proyecto
1. Copia la carpeta `vision_board_2026` a tu directorio de Laragon:
   - Ruta típica: `C:\laragon\www\vision_board_2026`

### 2. Crear la Base de Datos
1. Abre **phpMyAdmin** en tu navegador:
   - URL: `http://localhost/phpmyadmin`

2. Crea la base de datos:
   - Haz clic en "Nueva" en el panel izquierdo
   - Nombre: `vboard26`
   - Cotejamiento: `utf8mb4_unicode_ci`
   - Haz clic en "Crear"

3. Importa las tablas:
   - Selecciona la base de datos `vboard26`
   - Ve a la pestaña "SQL"
   - Copia y pega todo el contenido de `setup_database.sql`
   - Haz clic en "Continuar"

**ALTERNATIVA:** Puedes ejecutar el SQL directamente desde la línea de comandos:
```bash
mysql -u root -p vboard26 < setup_database.sql
```
(Presiona Enter cuando te pida contraseña, ya que root no tiene contraseña)

### 3. Verificar la Configuración
1. Abre el archivo `config.php` y verifica que la configuración sea correcta:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vboard26');
```

### 4. Acceder al Vision Board
1. Asegúrate de que Laragon esté ejecutándose (Apache y MySQL iniciados)
2. Abre tu navegador y ve a:
   - URL: `http://localhost/vision_board_2026`
   - O directamente: `http://localhost/vision_board_2026/index.php`

## Funcionalidades

### Sistema de Progreso
- **Puntos interactivos**: Haz clic en los círculos para marcar objetivos como completados
- **Guardado automático**: Cada clic se guarda inmediatamente en la base de datos
- **Persistencia**: Tu progreso se mantiene aunque cierres el navegador
- **Estadísticas en tiempo real**: Panel inferior muestra tu avance general

### Categorías de Objetivos
1. 🌱 **Crecimiento Profesional** - Nuevas tecnologías, dibujo, lectura, inglés, portafolio
2. 💼 **Trabajo & Propósito** - Búsqueda de trabajo remoto y alineación profesional
3. 🏃‍♂️ **Salud & Bienestar** - Ejercicio, ortodoncia, reducción de azúcar
4. 🍽️ **Vida Diaria** - Cocina y rutinas de autocuidado
5. 💰 **Finanzas** - Ahorros, pago de créditos
6. 🛵 **Movilidad** - Licencias de conducción

### Popups de Importancia
- Presiona "💡 ¿Por qué es importante?" en cada tarjeta
- Aprende sobre los beneficios de cada área de tu vida
- Motivación adicional basada en ciencia y mejores prácticas

## Estructura de la Base de Datos

### Tabla: goal_progress
Almacena el progreso de cada objetivo individual
- `id`: Identificador único
- `goal_id`: ID del objetivo (ej: 'tech-progress')
- `goal_index`: Índice del punto específico (0-N)
- `is_completed`: Estado de completado (boolean)
- `completed_date`: Fecha de completado
- `created_at`, `updated_at`: Timestamps

### Tabla: user_settings
Configuraciones del usuario
- `setting_key`: Clave de configuración (ej: 'start_date')
- `setting_value`: Valor de la configuración

### Tabla: activity_log
Registro de todas las acciones (opcional, para análisis futuro)
- `goal_id`, `goal_index`: Identificador del objetivo
- `action`: Tipo de acción ('completed' o 'uncompleted')
- `action_date`: Momento de la acción

## API Endpoints

### GET Requests
- `api.php?action=get_all_progress` - Obtener todo el progreso
- `api.php?action=get_stats` - Obtener estadísticas generales
- `api.php?action=get_start_date` - Obtener fecha de inicio

### POST Requests
- `api.php?action=toggle_progress` - Alternar estado de un objetivo
  ```json
  {
    "goal_id": "tech-progress",
    "goal_index": 0,
    "is_completed": true
  }
  ```

- `api.php?action=save_all_progress` - Guardar todo el progreso
  ```json
  {
    "progress": {
      "tech-progress": {
        "0": true,
        "1": false
      }
    }
  }
  ```

## Solución de Problemas

### Error de conexión a base de datos
- Verifica que MySQL esté ejecutándose en Laragon
- Confirma que la base de datos `vboard26` existe
- Revisa las credenciales en `config.php`

### Los cambios no se guardan
- Abre la consola del navegador (F12) y busca errores
- Verifica que `api.php` sea accesible: `http://localhost/vision_board_2026/api.php`
- Revisa los permisos de la carpeta del proyecto

### Las imágenes no cargan
- Las imágenes vienen de Unsplash
- Si no tienes internet, se mostrarán imágenes de respaldo SVG con el ícono de cada categoría

## Respaldo y Migración

### Exportar tu progreso
Desde phpMyAdmin:
1. Selecciona la base de datos `vboard26`
2. Ve a "Exportar"
3. Selecciona formato SQL
4. Descarga el archivo

### Importar progreso en otro equipo
1. Instala el proyecto en el nuevo equipo
2. Crea la base de datos `vboard26`
3. Importa el archivo SQL que exportaste

## Mejoras Futuras Sugeridas
- Sistema de autenticación para múltiples usuarios
- Gráficos de progreso a lo largo del tiempo
- Exportación de reportes PDF
- Notificaciones de recordatorios
- Sistema de recompensas/logros

## Contacto y Soporte
Si tienes problemas o sugerencias, documenta:
- Mensaje de error exacto
- Navegador que estás usando
- Versión de PHP/MySQL
- Pasos que causaron el problema

---

**¡Éxito en tu Vision Board 2026!** 🚀

Recuerda: La constancia es más importante que la perfección. Marca tus logros día a día.
# vision-board-2026
