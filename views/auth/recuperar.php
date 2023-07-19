<h1 class="nombre-pagina">Reestablece tu Contraseña</h1>
<p class="descripcion-pagina">Coloca un nuevo password a continuación</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if($error) return; ?>

<!-- INICIO Formulario -->
<form class="formulario" method="POST">

    <div class="campo">

        <label for="PASSWORD">Password</label>
        <input type="password" name="PASSWORD" id="PASSWORD" placeholder="Tu Nuevo Password">

    </div>

    <input type="submit" class="boton" value="Actualizar Password">

</form>
<!-- FIN Formulario -->
<!-- INICIO Acciones -->
<div class="acciones">

    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>

</div>
<!-- FIN Acciones -->