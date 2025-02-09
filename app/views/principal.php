<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CRUD CLIENTES</title>
    <link href="web/css/default.css" rel="stylesheet" type="text/css" />
    <!-- Mejora 10 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
    <script src="web/js/map.js"></script>

    <script type="text/javascript" src="web/js/funciones.js"></script>
</head>

<body>
    <div id="container" style="width: auto;">
        <div id="header">
            <h1>MIS CLIENTES CRUD versión 1.0</h1>
        </div>
        <hr>
        <div id="aviso">
            <?= $msg ?>
        </div>
        <div id="content">
            <?= $contenido ?>
        </div>
    </div>



</body>

</html>