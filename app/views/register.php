<!-- Mejora Extra -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CRUD CLIENTES</title>
    <link href="web/css/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="container" style="width: 950px;">
        <div id="header">
            <h1>MIS CLIENTES CRUD versión 1.0</h1>
        </div>
        <hr>
        <center>
            <h2>Registrar Nuevo Usuario</h2>
        </center>
        <form method="POST" action="index.php" class="forms">
            <input type="hidden" name="action" value="register">
            <label for="new_login">Usuario:</label>
            <input type="text" id="new_login" name="new_login" required><br>
            <label for="new_password">Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required><br>
            <label for="new_rol">Rol:</label>
            <select id="new_rol" name="new_rol">
                <option value="0">Usuario</option>
                <option value="1">Administrador</option>
            </select>
            <br>
            <br>
            <button type="submit">Registrar</button>
        </form>
        <button onclick="location.href='./'">Volver</button>
    </div>
</body>

</html>