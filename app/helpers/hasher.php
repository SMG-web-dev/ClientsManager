<?php
// Mejora 8 - Script para generar hashes de contraseñas

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Generar hashes para admin y user
$adminHash = hashPassword('admin');
$userHash = hashPassword('user');

echo "Hash para admin: " . $adminHash  . "<br>";
echo "Hash para user: " . $userHash;
