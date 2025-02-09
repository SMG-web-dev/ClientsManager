<br>
<table>
    <thead>
        <tr> <!-- Mejora 6 $orderBy -->
            <th><a href="?orden=list&orderBy=id">ID</a></th>
            <th><a href="?orden=list&orderBy=first_name">First Name</a></th>
            <th><a href="?orden=list&orderBy=email">Email</a></th>
            <th><a href="?orden=list&orderBy=gender">Gender</a></th>
            <th><a href="?orden=list&orderBy=ip_address">IP Address</a></th>
            <th>Teléfono</th>
            <!-- Mejora 9 -->
            <?php if ($_SESSION['user']['rol'] == 1): ?>
                <th colspan="3"></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tclientes as $cli): ?>
            <tr>
                <td><?= $cli->id ?> </td>
                <td><?= $cli->first_name ?> </td>
                <td><?= $cli->email ?> </td>
                <td><?= $cli->gender ?> </td>
                <td><?= $cli->ip_address ?> </td>
                <td><?= $cli->telefono ?> </td>
                <!-- Mejora 9 -->
                <?php if ($_SESSION['user']['rol'] == 1): ?>
                    <td><a href="#" onclick="confirmarBorrar('<?= $cli->first_name ?>','<?= $cli->id ?>');">Borrar</a></td>
                    <td><a href="?orden=Modificar&id=<?= $cli->id ?>">Modificar</a></td>
                    <td><a href="?orden=Detalles&id=<?= $cli->id ?>">Detalles</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="button-container">
    <form>
        <button name="nav" value="Primero">
            << </button>
                <button name="nav" value="Anterior">
                    < </button>
                        <button name="nav" value="Siguiente"> > </button>
                        <button name="nav" value="Ultimo"> >> </button>
    </form>
</div>

<div class="button-container">
    <?php if (empty($_GET['orden']) && isset($_SESSION['user'])): ?>

        <!-- Mejoras Extra - Registrar nuevos usuarios y clientes (solo para admin) -->
        <?php if ($_SESSION['user']['rol'] == 1): ?>
            <form><button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button></form>
            <form method="GET" action="index.php">
                <input type="hidden" name="action" value="register">
                <button type="submit">Registrar Nuevo Usuario</button>
            </form>
        <?php endif; ?>

    <?php endif; ?>
    <!-- Mejora Extra - Botón para cerrar sesión -->
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="logout">
        <button type="submit">Cerrar Sesión</button>
    </form>
</div>