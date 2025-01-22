  <hr>
  <button onclick="location.href='./'"> Volver </button>
  <br><br>
  <table>
    <tr>
      <td>id:</td>
      <td><input type="number" name="id" value="<?= $cli->id ?>" readonly> </td>
      <td rowspan="7">
        <img src=""></img>
      </td>
    </tr>
    <tr>
      <td>first_name:</td>
      <td><input type="text" name="first_name" value="<?= $cli->first_name ?>" readonly> </td>
    </tr>
    </tr>
    <tr>
      <td>last_name:</td>
      <td><input type="text" name="last_name" value="<?= $cli->last_name ?>" readonly></td>
    </tr>
    </tr>
    <tr>
      <td>email:</td>
      <td><input type="email" name="email" value="<?= $cli->email ?>" readonly></td>
    </tr>
    </tr>
    <tr>
      <td>gender</td>
      <td><input type="text" name="gender" value="<?= $cli->gender ?>" readonly></td>
    </tr>
    </tr>
    <tr>
      <td>ip_address:</td>
      <td><input type="text" name="ip_address" value="<?= $cli->ip_address ?>" readonly></td>
    </tr>
    </tr>
    <tr>
      <td>telefono:</td>
      <td><input type="tel" name="telefono" value="<?= $cli->telefono ?>" readonly></td>
    </tr>
    </tr>
  </table>
  <br>

  <!-- Mejora anterior/siguiente -->
  <div style="display: flex;">
    <?php if ($cli->idAnterior !== null): ?>
      <form method="get" action="index.php">
        <input type="hidden" name="orden" value="Detalles">
        <input type="hidden" name="id" value="<?= $cli->idAnterior ?>">
        <button type="submit">
          < </button>
      </form>
    <?php endif; ?>

    <?php if ($cli->idSiguiente !== null): ?>
      <form method="get" action="index.php">
        <input type="hidden" name="orden" value="Detalles">
        <input type="hidden" name="id" value="<?= $cli->idSiguiente ?>">
        <button type="submit"> > </button>
      </form>
    <?php endif; ?>
  </div>