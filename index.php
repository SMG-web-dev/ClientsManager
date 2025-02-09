<?php
session_start();
define('FPAG', 10); // Número de filas por página

require_once 'app/helpers/util.php';
require_once 'app/config/configDB.php';
require_once 'app/models/Cliente.php';
require_once 'app/models/AccesoDatosPDO.php';
require_once 'app/controllers/crudclientes.php';
require_once 'app/helpers/IPHelper.php';
require_once 'app/helpers/LocationHelper.php';

// Manejo de login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    include 'app/controllers/login.php';
    if (procesarLogin()) {
        // Login exitoso, redirigir
        header("Location: index.php");
        exit;
    }
    // Si el login falla, procesarLogin() ya establece los mensajes de error
    header("Location: index.php");
    exit;
}

// Mejora Extra - Acción para cerrar sesión  
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Mejora extra - Procesar registro de nuevos usuarios
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 1 && isset($_POST['action']) && $_POST['action'] == 'register') {
    $new_login = trim($_POST['new_login'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $new_rol = trim($_POST['new_rol'] ?? '');

    if ($new_login && $new_password && in_array($new_rol, [0, 1])) {
        $db = AccesoDatos::getModelo();
        $db->registrarUsuario($new_login, $new_password, $new_rol);
        $_SESSION['msg'] = "Usuario registrado correctamente.";
    } else {
        $_SESSION['msg'] = "Error al registrar el usuario.";
    }
    header("Location: index.php?action=register");
    exit;
}

// Mejora Extra Mostrar vista de registro si el usuario es admin
if (isset($_GET['action']) && $_GET['action'] == 'register' && isset($_SESSION['user']) && $_SESSION['user']['rol'] == 1) {
    include 'app/views/register.php';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Comprobar si el usuario está autenticado
if (isset($_SESSION['user'])) {
    // Mejora 6 $orderBy
    if (isset($_GET['orderBy'])) {
        $_SESSION['orderBy'] = $_GET['orderBy'];
    }
    $orderBy = $_SESSION['orderBy'] ?? 'id';

    //---- PAGINACIÓN ----
    $midb = AccesoDatos::getModelo();
    $totalfilas = $midb->numClientes();
    if ($totalfilas % FPAG == 0) {
        $posfin = $totalfilas - FPAG;
    } else {
        $posfin = $totalfilas - $totalfilas % FPAG;
    }

    if (!isset($_SESSION['posini'])) {
        $_SESSION['posini'] = 0;
    }
    $posAux = $_SESSION['posini'];
    //------------

    ob_start(); // La salida se guarda en el bufer
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        // Proceso las ordenes de navegación
        if (isset($_GET['nav'])) {
            switch ($_GET['nav']) {
                case "Primero":
                    $posAux = 0;
                    break;
                case "Siguiente":
                    $posAux += FPAG;
                    if ($posAux > $posfin) $posAux = $posfin;
                    break;
                case "Anterior":
                    $posAux -= FPAG;
                    if ($posAux < 0) $posAux = 0;
                    break;
                case "Ultimo":
                    $posAux = $posfin;
            }
            $_SESSION['posini'] = $posAux;
        }

        // Proceso de ordenes de CRUD clientes
        if (isset($_GET['orden'])) {
            switch ($_GET['orden']) {
                case "Nuevo":
                    if ($_SESSION['user']['rol'] == 1) {
                        crudAlta();
                    } else {
                        $_SESSION['msg'] = "No tienes permisos para esta acción.";
                    }
                    break;
                case "Borrar":
                    crudBorrar($_GET['id']);
                    break;
                case "Modificar":
                    crudModificar($_GET['id']);
                    break;
                case "Detalles":
                    crudDetalles($_GET['id']);
                    break;
                case "Terminar":
                    crudTerminar();
                    break;
                case "GenerarPDF":
                    crudGenerarPDF($_GET['id']);
                    break;
            }
        }
    }
    // POST Formulario de alta o de modificación
    else {
        if (isset($_POST['orden'])) {
            switch ($_POST['orden']) {
                case "Nuevo":
                    crudPostAlta();
                    break;
                case "Modificar":
                    crudPostModificar();
                    break;
                case "Detalles":; // No hago nada
            }
        }
    }

    // Mostrar la lista de clientes si no hay otra orden
    if (!isset($_GET['orden']) || $_GET['orden'] == 'list') {
        $db = AccesoDatos::getModelo();
        $posini = $_SESSION['posini'] ?? 0;
        $orderBy = $_SESSION['orderBy'] ?? 'id';
        $tclientes = $db->getClientes($posini, FPAG, $orderBy);
        include_once "app/views/list.php";
    }

    $contenido = ob_get_clean();
    $msg = $_SESSION['msg'] ?? '';

    // Limpiar el mensaje después de mostrarlo
    unset($_SESSION['msg']);

    // Mostrar la página principal con el contenido generado
    include_once "app/views/principal.php";
} else {
    // Si el usuario no está autenticado, mostrar el formulario de login
    include_once 'app/views/login.php';
}
