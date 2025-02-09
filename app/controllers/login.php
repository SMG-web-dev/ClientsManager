<?php // Mejora 8
// Mejoras extra para la logica de bloqueo de logins
function procesarLogin()
{
    session_start();

    // Verificar si el usuario está bloqueado
    if (verificarBloqueo()) {
        return false;
    }

    // Limpiar entradas
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$login || !$password) {
        registrarIntentoFallido("Por favor, completa todos los campos.");
        return false;
    }

    // Verificar usuario
    $db = AccesoDatos::getModelo();
    $user = $db->verificarUsuario($login, $password);

    if ($user) {
        // Inicio de sesión exitoso
        $_SESSION['user'] = $user;
        $_SESSION['login_success'] = "Inicio de sesión exitoso.";
        resetearIntentos();
        return true;
    } else {
        // Error de inicio de sesión
        registrarIntentoFallido("Nombre de usuario o contraseña incorrectos.");
        return false;
    }
}

function verificarBloqueo()
{
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = [
            'numero' => 0,
            'tiempo_bloqueo' => null
        ];
    }

    // Si existe un bloqueo, verificar si ya pasó el tiempo
    if ($_SESSION['intentos']['tiempo_bloqueo'] !== null) {
        if (time() < $_SESSION['intentos']['tiempo_bloqueo']) {
            // Todavía está bloqueado
            $minutos_restantes = ceil(($_SESSION['intentos']['tiempo_bloqueo'] - time()) / 60);
            $_SESSION['login_error'] = "Cuenta bloqueada. Intente nuevamente en $minutos_restantes minutos.";
            return true;
        } else {
            // Ya pasó el tiempo de bloqueo
            resetearIntentos();
        }
    }

    return false;
}

function registrarIntentoFallido($mensaje)
{
    $_SESSION['intentos']['numero']++;

    $intentos_restantes = 3 - $_SESSION['intentos']['numero'];

    if ($_SESSION['intentos']['numero'] >= 3) {
        // Bloquear por 1 minuto
        $_SESSION['intentos']['tiempo_bloqueo'] = time() + (60);
        $_SESSION['login_error'] = "Demasiados intentos fallidos. Cuenta bloqueada por 15 minutos.";
    } else {
        $_SESSION['login_error'] = "$mensaje (Intentos restantes: $intentos_restantes)";
    }
}

function resetearIntentos()
{
    $_SESSION['intentos'] = [
        'numero' => 0,
        'tiempo_bloqueo' => null
    ];
}
