<!--  Mejora 8 -->
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
        <form method="POST" action="index.php" class="forms">
            <input type="hidden" name="action" value="login">
            <label for="login">Usuario:</label>
            <input type="text" id="login" name="login" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Iniciar sesión">
        </form>
        <?php
        // Mensajes de error o éxito
        if (isset($_SESSION['login_error'])) {
            echo "<p style='color:red;'>{$_SESSION['login_error']}</p>";
            unset($_SESSION['login_error']);
        }
        if (isset($_SESSION['login_success'])) {
            echo "<p style='color:green;'>{$_SESSION['login_success']}</p>";
            unset($_SESSION['login_success']);
        }
        ?>
    </div>
</body>

</html>