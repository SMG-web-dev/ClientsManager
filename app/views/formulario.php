<?php
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);
?>
<hr>
<form method="POST" enctype="multipart/form-data">
    <label for="id">Id:</label>
    <input type="text" name="id" readonly value="<?= $cli->id ?>">

    <label for="first_name">Nombre:</label>
    <input type="text" id="first_name" name="first_name" value="<?= $cli->first_name; ?>">

    <label for="last_name">Apellido:</label>
    <input type="text" id="last_name" name="last_name" value="<?= $cli->last_name; ?>">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $cli->email; ?>">

    <!-- Mejora 2 -->
    <?php if (isset($errores['email'])): ?>
        <span style="color: red; margin-bottom: 1rem;"><?= $errores['email'] ?></span>
    <?php endif; ?>

    <label for="gender">Género:</label>
    <input type="text" id="gender" name="gender" value="<?= $cli->gender; ?>">

    <label for="ip_address">Dirección IP:</label>
    <input type="text" id="ip_address" name="ip_address" value="<?= $cli->ip_address; ?>">

    <!-- Mejora 2 -->
    <?php if (isset($errores['ip_address'])): ?>
        <span style="color: red; margin-bottom: 1rem;"><?= $errores['ip_address'] ?></span>
    <?php endif; ?>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" value="<?= $cli->telefono; ?>">

    <!-- Mejora 2 -->
    <?php if (isset($errores['telefono'])): ?>
        <span style="color: red; margin-bottom: 1rem;"><?= $errores['telefono'] ?></span>
    <?php endif; ?>

    <!-- Mejora 4 -->
    <div style="margin:2rem;">
        <label for="image">Imagen (JPG o PNG, máximo 500KB):</label>
        <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png">
    </div>


    <input type="submit" name="orden" value="<?= $orden ?>">
    <input type="submit" name="orden" value="Volver">
</form>
<br>

<!-- Mejora 1 -->
<?php if ($orden == "Modificar") : ?>
    <div style="display: flex;">
        <?php if ($cli->idAnterior !== null): ?>
            <form method="get" action="index.php">
                <input type="hidden" name="orden" value="Modificar">
                <input type="hidden" name="id" value="<?= $cli->idAnterior ?>">
                <button type="submit">
                    < </button>
            </form>
        <?php endif; ?>

        <?php if ($cli->idSiguiente !== null): ?>
            <form method="get" action="index.php">
                <input type="hidden" name="orden" value="Modificar">
                <input type="hidden" name="id" value="<?= $cli->idSiguiente ?>">
                <button type="submit"> > </button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>