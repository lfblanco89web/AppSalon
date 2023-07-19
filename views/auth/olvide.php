<h1 class="nombre-pagina">Sistema de Recuperación</h1>
<p class="descripcion-pagina">Completa los datos para recuperar tu Password</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<!-- INICIO Formulario -->
<form class="formulario" action="/olvide" method="POST">

    <div class="campo">

        <label for="EMAIL">Email</label>
        <input type="email" id="EMAIL" name="EMAIL" placeholder="Tu E-mail">

    </div>

    <input type="submit" class="boton" value="Verificar E-mail">

</form>
<!-- FIN Formulario -->
<!-- INICIO Acciones -->
<div class="acciones">

    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>    
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>

</div>
<!-- FIN Acciones -->