<?php
// C:\xampp\htdocs\labmind\modules\auth\authenticate.php

// Incluir config.php para definir ROOT_PATH y constantes de DB
require_once dirname(__DIR__, 2) . '/config.php';

// Incluir las clases y funciones necesarias
require_once ROOT_PATH . 'includes/db_connection.php';
require_once ROOT_PATH . 'includes/auth_middleware.php'; // Si tienes funciones aquí, como get_input, etc.
require_once ROOT_PATH . 'includes/functions.php'; // Asegúrate que get_input() esté aquí si la usas

// NO debe haber llamadas a auth_middleware::check_session(); aquí.
// Este controlador es para manejar la autenticación en sí misma.

$is_logout_request = (isset($_GET['action']) && $_GET['action'] === 'logout');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Es una solicitud POST (intento de login)
    $username = get_input('identity'); // Usar 'identity' si tu formulario lo envía así
    $password = get_input('password');

    // Validación básica de entrada
    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Por favor, ingresa usuario/email y contraseña.";
        require_once ROOT_PATH . 'views/login.php';
        exit; // Salir después de mostrar el formulario con error
    }

    $db = new DatabaseConnection();

    // Consulta para obtener el usuario por username o email
    // Asumo que tu tabla 'users' tiene columnas 'username' y 'email'
    $sql = "SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ?";
    $stmt = $db->connection->prepare($sql); // Usar prepared statements para seguridad
    $stmt->bind_param("ss", $username, $username); // Se usa 'username' dos veces para buscar en ambas columnas
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña (usando password_verify si las contraseñas están hasheadas)
        if (password_verify($password, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? 'user'; // Asigna un rol por defecto si no existe
            unset($_SESSION['login_error']); // Limpia cualquier error previo

            $db->close_connection();
            header("Location: " . BASE_URL . "reception/work_order/listing");
            exit; // MUY IMPORTANTE: Salir después de la redirección
        }
    }
    
    // Si las credenciales son incorrectas (usuario no encontrado o contraseña no coincide)
    $_SESSION['login_error'] = "Usuario o contraseña incorrectos.";
    $db->close_connection();
    require_once ROOT_PATH . 'views/login.php'; // Mostrar el formulario de login con el error
    exit; // Salir después de incluir la vista
} elseif ($is_logout_request) { // Solo si es una solicitud GET para 'logout'
    // Es una solicitud de logout
    session_destroy();
    session_unset();
    header("Location: " . BASE_URL . "auth/authenticate"); // Redirigir al login después de logout
    exit;
} else {
    // Es una solicitud GET (carga inicial de la página de login)
    // Mostrar el formulario de login
    unset($_SESSION['login_error']); // Limpiar errores previos al cargar la página por primera vez
    require_once ROOT_PATH . 'views/login.php';
    exit; // Salir después de incluir la vista
}

// Nota: No debe haber más código aquí que no sea alcanzable por los exit;
// Esto es para asegurar que solo una vista se cargue o una redirección ocurra.
?>
