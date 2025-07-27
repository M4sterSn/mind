<?php
// C:\xampp\htdocs\labmind\index.php

// ¡¡¡CRÍTICO: INICIAR LA SESIÓN LO PRIMERO DE TODO!!!
// Si ya hay una sesión activa, esta línea la ignora y no produce warnings.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Enrutador principal del sistema LabMind.
 * Este archivo centraliza todas las solicitudes HTTP y las dirige a los módulos/vistas correspondientes.
 */

// Cargar la configuración global
require_once __DIR__ . '/config.php';

// Cargar funciones auxiliares (DEBE SER INCLUIDO ANTES DE USAR CUALQUIER FUNCIÓN)
require_once INCLUDES_PATH . 'functions.php';

// Cargar el middleware de autenticación (DEBE SER INCLUIDO ANTES DE USAR require_login/require_role)
require_once INCLUDES_PATH . 'auth_middleware.php';

// Obtener la URI solicitada
$request_uri = $_SERVER['REQUEST_URI'];

// Obtener la ruta base del proyecto a partir de BASE_URL para eliminarla de la URI
$base_url_parsed = parse_url(BASE_URL, PHP_URL_PATH);
// Asegurarse de que termine con una barra para coincidir con la URL real
$base_url_path = rtrim($base_url_parsed, '/') . '/';

// Eliminar la BASE_URL de la URI para obtener solo la ruta relativa a la aplicación.
// Esto es crucial para que el enrutador funcione correctamente independientemente de la subcarpeta.
if (strpos($request_uri, $base_url_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_url_path));
}
$request_uri = trim($request_uri, '/'); // Eliminar barras iniciales y finales

// Dividir la URL en partes para un enrutamiento más fácil
$uri_segments = explode('/', $request_uri);

// Definir el módulo y la acción por defecto
$module = isset($uri_segments[0]) && $uri_segments[0] !== '' ? $uri_segments[0] : 'reception_work_order_listing';
$action = isset($uri_segments[1]) ? $uri_segments[1] : 'index'; // Acción por defecto
$id = isset($uri_segments[2]) ? $uri_segments[2] : null; // ID o parámetro adicional

// --- Enrutamiento ---
switch ($module) {
    case 'login':
        // Si el formulario de login se envió (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once MODULES_PATH . 'auth/authenticate.php';
        } else {
            // Mostrar la vista de login para solicitudes GET
            require_once VIEWS_PATH . 'login.php';
        }
        break;

    case 'logout':
        require_once MODULES_PATH . 'auth/authenticate.php'; // Usa el mismo controlador para logout
        break;

    case 'reception_work_order_listing':
        // Proteger esta ruta: si no está logeado, redirige a login
        require_login();
        require_once VIEWS_PATH . 'reception_work_order_listing.php';
        break;

    case 'admin':
        require_login(); // Protege la sección de administración
        require_role('admin'); // Solo administradores
        switch ($action) {
            case 'users':
                // require_once MODULES_PATH . 'admin/users_controller.php';
                // De momento, cargamos una vista placeholder si no existe el controlador
                echo "<h1>Admin - Gestión de Usuarios</h1><p>Esta es la página de gestión de usuarios. (Controlador: " . MODULES_PATH . "admin/users_controller.php)</p>";
                break;
            case 'settings':
                // require_once MODULES_PATH . 'admin/settings_controller.php';
                echo "<h1>Admin - Configuración</h1><p>Esta es la página de configuración. (Controlador: " . MODULES_PATH . "admin/settings_controller.php)</p>";
                break;
            default:
                // Redirigir a dashboard si la sub-ruta de admin no es válida
                set_session_message("Página de administración no encontrada.", "error");
                redirect(BASE_URL . 'reception_work_order_listing');
                break;
        }
        break;

    case 'reception':
        require_login();
        // require_role('receptionist'); // Descomentar cuando tengamos roles
        switch ($action) {
            case 'work_order':
                // require_once MODULES_PATH . 'reception/work_order_controller.php';
                echo "<h1>Recepción - Órdenes de Trabajo</h1><p>Aquí se gestionarán las órdenes de trabajo. (Controlador: " . MODULES_PATH . "reception/work_order_controller.php)</p>";
                break;
            case 'insert': // Para /reception/insert
                // require_once MODULES_PATH . 'reception/insert_controller.php'; // Considera un controlador específico
                echo "<h1>Recepción - Insertar Nueva Orden</h1><p>Aquí se insertará una nueva orden de trabajo.</p>";
                break;
            default:
                // Redirigir a dashboard si la sub-ruta de recepción no es válida
                set_session_message("Página de recepción no encontrada.", "error");
                redirect(BASE_URL . 'reception_work_order_listing');
                break;
        }
        break;

    case 'patients':
        require_login();
        // require_once MODULES_PATH . 'patients/patients_controller.php';
        echo "<h1>Gestión de Pacientes</h1><p>Aquí irán las funciones CRUD para pacientes. (Controlador: " . MODULES_PATH . "patients/patients_controller.php)</p>";
        break;

    case 'doctors':
        require_login();
        // require_once MODULES_PATH . 'doctors/doctors_controller.php';
        echo "<h1>Gestión de Médicos</h1><p>Aquí irán las funciones CRUD para médicos. (Controlador: " . MODULES_PATH . "doctors/doctors_controller.php)</p>";
        break;

    case 'studies':
        require_login();
        // require_once MODULES_PATH . 'studies/studies_controller.php';
        echo "<h1>Gestión de Estudios</h1><p>Aquí irán las funciones CRUD para estudios. (Controlador: " . MODULES_PATH . "studies/studies_controller.php)</p>";
        break;

    case 'results':
        // Esta ruta puede ser pública si es para consultar resultados por QR
        // require_once VIEWS_PATH . 'results/view.php';
        echo "<h1>Consulta de Resultados</h1><p>Aquí se podrán consultar los resultados de los estudios.</p>";
        break;

    default:
        // Si la URL no coincide con ninguna ruta conocida, redirige al login
        // Sin establecer mensaje, ya que auth_middleware se encargaría del mensaje de login.
        redirect(BASE_URL . 'login');
        break;
}

?>