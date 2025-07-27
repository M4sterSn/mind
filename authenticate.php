<?php
/**
 * Controlador de autenticación para el sistema LabMind.
 * Maneja el inicio de sesión y el cierre de sesión.
 */

// Asegúrate de que config.php, db_connection.php y functions.php estén incluidos
if (!defined('BASE_URL')) {
    require_once dirname(dirname(__DIR__)) . '/config.php';
}
require_once INCLUDES_PATH . 'db_connection.php'; // Necesario para interactuar con la DB
require_once INCLUDES_PATH . 'functions.php';    // Necesario para redirect, set_session_message, get_input, etc.

// Obtener la conexión a la base de datos
$conn = get_db_connection(); // ¡CRÍTICO: Asegúrate de tener esta línea!

// Detectar si la acción es 'logout' a través del enrutador
$is_logout_request = (isset($module) && $module === 'logout');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_logout_request) {
    // --- Lógica de Inicio de Sesión (solo para solicitudes POST que no son logout) ---
    $identity = get_input('identity'); // 'username' o 'email'
    $password = get_input('password');

    if (empty($identity) || empty($password)) {
        // CORRECCIÓN AQUÍ: Cambiar el orden de los argumentos a (tipo, mensaje)
        set_session_message("error", "Por favor, ingresa tu usuario y contraseña.");
        redirect(BASE_URL . 'login');
    }

    // Preparar la consulta SQL para buscar al usuario por username
    $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ? AND is_active = 1 LIMIT 1"); // <-- Usa $conn->prepare
    if (!$stmt) {
        // CORRECCIÓN AQUÍ: Cambiar el orden de los argumentos a (tipo, mensaje)
        set_session_message("error", "Error interno del servidor al preparar consulta. Inténtalo de nuevo.");
        error_log("Error al preparar la consulta de login: " . $conn->error); // <-- Usa $conn->error
        redirect(BASE_URL . 'login');
    }

    $stmt->bind_param("s", $identity);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña hasheada
        if (password_verify($password, $user['password_hash'])) {
            // Autenticación exitosa
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true; // Flag para indicar sesión activa

            set_session_message("success", "¡Bienvenido, " . htmlspecialchars($user['username']) . "!");
            redirect(BASE_URL . 'reception_work_order_listing'); // Redirigir al dashboard
        } else {
            // Contraseña incorrecta
            // CORRECCIÓN AQUÍ: Cambiar el orden de los argumentos a (tipo, mensaje)
            set_session_message("error", "Credenciales incorrectas.");
            redirect(BASE_URL . 'login');
        }
    } else {
        // Usuario no encontrado o inactivo
        // CORRECCIÓN AQUÍ: Cambiar el orden de los argumentos a (tipo, mensaje)
        set_session_message("error", "Credenciales incorrectas.");
        redirect(BASE_URL . 'login');
    }

    $stmt->close();
    $conn->close(); // <-- Usa $conn->close (Cerrar la conexión DB)

} elseif ($is_logout_request) {
    // --- Lógica de Cierre de Sesión ---
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Destruir la cookie de sesión si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();
        // CORRECCIÓN AQUÍ: Cambiar el orden de los argumentos a (tipo, mensaje)
        set_session_message("info", "Has cerrado sesión correctamente.");
    }
    redirect(BASE_URL . 'login'); // Siempre redirigir a la página de login después de logout
} else {
    // Si se accede a authenticate.php directamente sin POST y no es logout, redirigir a login
    redirect(BASE_URL . 'login');
}
?>