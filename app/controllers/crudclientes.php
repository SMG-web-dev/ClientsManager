<?php

function crudBorrar($id)
{
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ($resu) {
        $_SESSION['msg'] = " El usuario " . $id . " ha sido eliminado.";
    } else {
        $_SESSION['msg'] = " Error al eliminar el usuario " . $id . ".";
    }
}

function crudTerminar()
{
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta()
{
    $cli = new Cliente();
    $orden = "Nuevo";
    include_once "app/views/formulario.php";
}

// Mejora anterior/siguiente
function crudDetalles($id = null)
{
    $db = AccesoDatos::getModelo();

    // Validación del ID
    if ($id === null || !is_numeric($id)) {
        // Manejar el error - por ejemplo redirigir a la lista principal
        header("Location: index.php");
        exit();
    }

    // Intentar obtener el cliente
    $cli = $db->getCliente((int)$id);

    // Validar si se encontró el cliente
    if ($cli === null) {
        // Manejar el caso de cliente no encontrado
        header("Location: index.php");
        exit();
    }

    include_once "app/views/detalles.php";
}


// Mejora anterior/siguiente
function crudModificar($id = null)
{
    if ($id === null) {
        // Manejar el error - redirigir o mostrar mensaje
        header("Location: index.php");
        exit();
    }

    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function crudPostAlta()
{
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $errores = [];

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato de correo electrónico incorrecto.";
    } else {
        $db = AccesoDatos::getModelo();
        if ($db->getClienteByEmail($_POST['email'])) {
            $errores['email'] = "Este correo electrónico ya está registrado.";
        }
    }

    // Validar IP
    if (!filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) {
        $errores['ip_address'] = "Formato de dirección IP incorrecto.";
    }

    // Validar teléfono
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $_POST['telefono'])) {
        $errores['telefono'] = "Formato de teléfono incorrecto (999-999-9999).";
    }

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        $cli = new Cliente();
        $cli->id            = $_POST['id'];
        $cli->first_name    = $_POST['first_name'];
        $cli->last_name     = $_POST['last_name'];
        $cli->email         = $_POST['email'];
        $cli->gender        = $_POST['gender'];
        $cli->ip_address    = $_POST['ip_address'];
        $cli->telefono      = $_POST['telefono'];
        $orden = "Nuevo";
        include_once "app/views/formulario.php";
        return;
    }

    $cli = new Cliente();
    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];
    $db = AccesoDatos::getModelo();
    if ($db->addCliente($cli)) {
        $_SESSION['msg'] = " El usuario " . $cli->first_name . " se ha dado de alta ";
    } else {
        $_SESSION['msg'] = " Error al dar de alta al usuario " . $cli->first_name . ".";
    }
}

function crudPostModificar()
{
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $errores = [];
    $id = $_POST['id'];

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato de correo electrónico incorrecto.";
    } else {
        $db = AccesoDatos::getModelo();
        $clienteExistente = $db->getClienteByEmail($_POST['email']);
        if ($clienteExistente && $clienteExistente->id != $id) {
            $errores['email'] = "Este correo electrónico ya está registrado.";
        }
    }

    // Validar IP
    if (!filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) {
        $errores['ip_address'] = "Formato de dirección IP incorrecto.";
    }

    // Validar teléfono
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $_POST['telefono'])) {
        $errores['telefono'] = "Formato de teléfono incorrecto (999-999-9999).";
    }

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        $cli = new Cliente();
        $cli->id            = $_POST['id'];
        $cli->first_name    = $_POST['first_name'];
        $cli->last_name     = $_POST['last_name'];
        $cli->email         = $_POST['email'];
        $cli->gender        = $_POST['gender'];
        $cli->ip_address    = $_POST['ip_address'];
        $cli->telefono      = $_POST['telefono'];
        $orden = "Modificar";
        include_once "app/views/formulario.php";
        return;
    }

    $cli = new Cliente();
    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];
    $db = AccesoDatos::getModelo();
    if ($db->modCliente($cli)) {
        $_SESSION['msg'] = " El usuario ha sido modificado";
    } else {
        $_SESSION['msg'] = " Error al modificar el usuario ";
    }
}
