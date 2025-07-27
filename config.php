<?php
// C:\xampp\htdocs\labmind\config.php

// Rutas base para el sistema
define('BASE_URL', '/labmind/'); // Asegúrate de que esta URL base sea correcta para tu configuración XAMPP

// Rutas del sistema de archivos (absolutas en el servidor)
define('ROOT_PATH', __DIR__ . '/'); // Raíz del proyecto (donde está config.php)
define('APP_PATH', ROOT_PATH . 'app/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('MODULES_PATH', ROOT_PATH . 'modules/'); // ¡Esta es la corrección clave según tu estructura!
define('CONTROLLERS_PATH', APP_PATH . 'controllers/'); // Asumiendo que controllers/ está en app/
define('MODELS_PATH', APP_PATH . 'models/'); // Asumiendo que models/ está en app/

// Rutas para recursos estáticos (CSS, JS, IMGs) ACCESIBLES POR EL NAVEGADOR
define('CSS_PATH', BASE_URL . 'css/');
define('JS_PATH', BASE_URL . 'js/');
define('IMG_PATH', BASE_URL . 'img/');


// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // ¡AJUSTA ESTO a la contraseña de tu usuario 'root' en MySQL/MariaDB!
define('DB_NAME', 'lcs'); // Nombre de tu base de datos (lcs)

// Nombre del Proyecto (para mostrar en el título, etc.)
define('PROJECT_NAME', 'LabMind');

// NO DEBE HABER NINGÚN session_start(), ini_set() o session_set_cookie_params() AQUÍ
?>