<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Completa el siguiente formulario</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<!-- INICIO Formulario -->
<form class="formulario" method="POST" action="/crear-cuenta">

    <div class="campo">

        <label for="NOMBRE">Nombre</label>
        <input type="text" name="NOMBRE" id="NOMBRE" placeholder="Tu Nombre"
        value="<?php echo s($usuario->NOMBRE); ?>">

    </div>

    <div class="campo">

        <label for="APELLIDO">Nombre</label>
        <input type="text" name="APELLIDO" id="APELLIDO" placeholder="Tu Apellido"
        value="<?php echo s($usuario->APELLIDO); ?>">

    </div>

    <div class="campo">

        <label for="TELEFONO">Teléfono</label>
        <input type="tel" name="TELEFONO" id="TELEFONO" placeholder="Tu Teléfono"
        value="<?php echo s($usuario->TELEFONO); ?>">

    </div>

    <div class="campo">

        <label for="EMAIL">E-mail</label>
        <input type="email" name="EMAIL" id="EMAIL" placeholder="Tu E-mail"
        value="<?php echo s($usuario->EMAIL); ?>">

    </div>

    <div class="campo">

        <label for="PASSWORD">Password</label>
        <input type="password" name="PASSWORD" id="PASSWORD" placeholder="Tu Password">

    </div>

    <input type="submit" value="Crear Cuenta" class="boton">

</form>
<!-- FIN Formulario -->
<!-- INICIO Acciones -->
<div class="acciones">

    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>

</div>
<!-- FIN Acciones -->