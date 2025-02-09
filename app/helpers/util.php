<?php

/*
 *  Funciones para limpiar la entrada de posibles inyecciones
 */

function limpiarEntrada(string $entrada): string
{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada)
{

    foreach ($entrada as $key => $value) {
        $entrada[$key] = limpiarEntrada($value);
    }
}

// Mejora 9 - Restriccion
function comprobarPermisos()
{

    if ($_SESSION['user']['rol'] != 1) {
        $_SESSION['msg'] = "No tienes permisos para crear nuevos clientes.";
        header("Location: index.php");
        exit;
    }
}
