<!-- Mejora imágenes -->
<?php
$imagePath = "app/uploads/" . sprintf("%08d.jpg", $cli->id);
if (!file_exists($imagePath)) {
  $imagePath = "https://robohash.org/" . $cli->id . "?size=250x250";
}
?>
<hr>
<button onclick="location.href='./'"> Volver </button>
<br><br>
<table>
  <tr>
    <td>id:</td>
    <td><input type="number" name="id" value="<?= $cli->id ?>" readonly> </td>
    <td rowspan="7">
      <img src="<?= $imagePath ?>" alt="Client Image" style="width: 100%; height: 100%; object-fit: cover;"></img>
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
    <td>
      <?= $cli->ip_address ?>
      <!-- Mejora 5 -->
      <?php
      $countryCode = IPHelper::getCountryFromIP($cli->ip_address);
      if ($countryCode):
        $flagUrl = IPHelper::getFlagUrl($countryCode, "w40");
      ?>
        <img src="<?= $flagUrl ?>"
          alt="Country flag"
          style="margin-left: 1rem; vertical-align: middle; border: 1px solid black;"
          onerror="this.style.display='none'">
      <?php else: ?>
        <span style="margin-left: 10px; color: #666; font-style: italic;">
          (País desconocido)
        </span>
      <?php endif; ?>
      <!-------------->
    </td>
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

<!-- Mejora 10 -->
<div class="map-container">
  <h2>Localización Geográfica</h2>
  <?php
  $location = LocationHelper::getLocationFromIP($cli->ip_address);
  if ($location):
  ?>
    <div id="map"></div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const mapElement = document.getElementById('map');
        if (mapElement) {
          const coordinates = {
            lat: <?= $location['lat'] ?? 0 ?>,
            lon: <?= $location['lon'] ?? 0 ?>
          };
          initializeMap('map', coordinates);
        }
      });
    </script>
  <?php else: ?>
    <div class="location-info">
      No se pudo obtener la localización para esta dirección IP.
    </div>
  <?php endif; ?>
</div>