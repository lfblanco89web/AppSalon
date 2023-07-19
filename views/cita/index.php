<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios a continuación</p>

<!-- INICIO App -->
<div class="app">

    <!-- INICIO Navegador -->
    <nav class="tabs">

        <!-- INICIO Botonera -->
        <button type="button"  class="actual" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Cita</button>
        <button type="button" data-paso="3">Resumen</button>
        <!-- FIN Botonera -->

    </nav>
    <!-- FIN Navegador -->

    <!-- INICIO Paso 1 -->
    <div id="paso-1" class="seccion">

        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios</p>

        <!-- INICIO Servicios -->
        <div id="servicios" class="listado-servicios">


        </div>
        <!-- FIN Servicios -->

    </div>
    <!-- FIN Paso 1 -->

    <!-- INICIO Paso 2 -->
    <div id="paso-2" class="seccion">

        <h2>Cita</h2>
        <p class="text-center">Completa los datos de la Cita</p>

        <!-- INICIO Formulario -->
        <form class="formulario">

            <div class="campo">

                <label for="NOMBRE">Nombre</label>
                <input type="text" name="NOMBRE" id="NOMBRE" placeholder="Tu Nombre" value="<?php echo $NOMBRE ?>" disabled>

            </div>

            <div class="campo">

                <label for="FECHA">Fecha</label>
                <input type="date" name="FECHA" id="FECHA" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">

            </div>

            <div class="campo">

                <label for="HORA">Hora</label>
                <input type="time" name="HORA" id="HORA">

            </div>

        </form>
        <!-- FIN Formulario -->

    </div> 
    <!-- FIN Paso 2 -->

    <!-- INICIO Paso 3 -->
    <div id="paso-3" class="seccion contenido-resumen">

        <h2>Resumen</h2>
        <p class="text-center">Verifica la información</p>

    </div>
    <!-- FIN Paso 3 -->

    <!-- INICIO Paginación -->
    <div id="paginacion" class="paginacion">

        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>

    </div>
    <!-- FIN Paginación -->

</div>
<!-- FIN App -->

<!-- Scripts -->
<?php

    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/bundle.min.js'></script>
    ";

?>