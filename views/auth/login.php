<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<!-- INICIO Formulario -->
<form class="formulario" action="/" method="POST">

    <div class="campo">

        <label for="EMAIL">E-mail</label>
        <input type="email" id="EMAIL" name="EMAIL" placeholder="Tu E-mail"
        value = "<?php echo s($auth->EMAIL);?>">

    </div>

    <div class="campo">

        <label for="PASSWORD">Contraseña</label>
        <input type="password" id="PASSWORD" name="PASSWORD" placeholder="Tu Contraseña">

    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

</form>
<!-- FIN Formulario -->
<!-- INICIO Acciones -->
<div class="acciones">

    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>

</div>
<!-- FIN Acciones -->
