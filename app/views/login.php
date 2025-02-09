<!DOCTYPE html>
<html>

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

        <?php
        // Verificar si está bloqueado para deshabilitar el formulario
        $bloqueado = isset($_SESSION['intentos']['tiempo_bloqueo']) &&
            $_SESSION['intentos']['tiempo_bloqueo'] > time();
        ?>

        <form method="POST" action="index.php" class="forms">
            <input type="hidden" name="action" value="login">

            <label for="login">Usuario:</label>
            <input type="text" id="login" name="login" required
                <?= $bloqueado ? 'disabled' : '' ?>><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required
                <?= $bloqueado ? 'disabled' : '' ?>><br>

            <input type="submit" value="Iniciar sesión"
                <?= $bloqueado ? 'disabled' : '' ?>>
        </form>
        <br>
        <?php
        // Mensajes de error o éxito
        if (isset($_SESSION['login_error'])) {
            echo "<div class='mensaje-error'>{$_SESSION['login_error']}</div>";
            unset($_SESSION['login_error']);
        }
        if (isset($_SESSION['login_success'])) {
            echo "<div class='mensaje-exito'>{$_SESSION['login_success']}</div>";
            unset($_SESSION['login_success']);
        }
        ?>
    </div>

</body>

</html>