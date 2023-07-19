<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppSalon</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>

<body>

    <!-- INICIO CONTENEDOR de la APP -->
    <div class="contenedor-app">

        <!-- INICIO Imagen Lateral -->
        <div class="imagen">

        </div>
        <!-- FIN Imagen Lateral -->
        <!-- INICIO APP -->
        <div class="app">

            <?php echo $contenido; ?>

        </div>
        <!-- FIN APP -->

    </div>
    <!-- FIN CONTENEDOR de la APP -->

    <?php echo $script ?? ''; ?>

</body>

</html>