<?php // Mejora 8

function procesarLogin()
{
    session_start();

    // Limpiar entradas
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$login || !$password) {
        $_SESSION['login_error'] = "Por favor, completa todos los campos.";
        header("Location: index.php");
        exit;
    }

    // Verificar usuario
    $db = AccesoDatos::getModelo();
    $user = $db->verificarUsuario($login, $password);

    if ($user) {
        // Inicio de sesión exitoso
        $_SESSION['user'] = $user;
        $_SESSION['login_success'] = "Inicio de sesión exitoso.";
        header("Location: index.php");
        exit;
    } else {
        // Error de inicio de sesión
        $_SESSION['login_error'] = "Nombre de usuario o contraseña incorrectos.";
        header("Location: index.php");
        exit;
    }
}
