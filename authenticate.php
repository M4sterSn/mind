<?php
// C:\xampp\htdocs\labmind\modules\auth\authenticate.php

// 1. Incluir config.php para definir ROOT_PATH y las constantes de la base de datos.
// Se usa dirname(__DIR__, 2) porque ROOT_PATH aún no está definida en este punto.
require_once dirname(__DIR__, 2) . '/config.php';

// Ahora que config.php ha sido incluido, ROOT_PATH ya está definida y disponible.

// 2. Incluir db_connection.php usando ROOT_PATH.
// db_connection.php está en la carpeta 'includes' que está en la raíz del proyecto.
require_once ROOT_PATH . 'includes/db_connection.php';

// 3. Incluir auth_middleware.php usando ROOT_PATH.
// auth_middleware.php también está en la carpeta 'includes'.
require_once ROOT_PATH . 'includes/auth_middleware.php';

// Obtener la conexión a la base de datos
$db = new DatabaseConnection(); // <--- ESTO ES LO CORRECTO

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
