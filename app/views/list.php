<form>
    <button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>
</form>
<br>
<table>
    <thead>
    <tr>    <!-- Mejora 6 $orderBy -->
            <th><a href="?orden=list&orderBy=id">ID</a></th>
            <th><a href="?orden=list&orderBy=first_name">First Name</a></th>
            <th><a href="?orden=list&orderBy=email">Email</a></th>
            <th><a href="?orden=list&orderBy=gender">Gender</a></th>
            <th><a href="?orden=list&orderBy=ip_address">IP Address</a></th>
            <th>Teléfono</th>
            <th colspan="3" ></th>
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
                <td><a href="#" onclick="confirmarBorrar('<?= $cli->first_name ?>','<?= $cli->id ?>');">Borrar</a></td>
                <td><a href="?orden=Modificar&id=<?= $cli->id ?>">Modificar</a></td>
                <td><a href="?orden=Detalles&id=<?= $cli->id ?>">Detalles</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<form>
    <button name="nav" value="Primero"> << </button>
    <button name="nav" value="Anterior"> < </button>
    <button name="nav" value="Siguiente"> > </button>
    <button name="nav" value="Ultimo"> >> </button>
</form>