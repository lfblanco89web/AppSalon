<?php

//DEFINICIONES
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');


//DEBUGUEAR
function debuguear($variable)
{

    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//INCLUIR Template
function incluirTemplate(string $nombre, bool $inicio = false)
{

    include TEMPLATES_URL . "/$nombre.php";
}

//VERIFICAR Usuario Autenticado
function autenticacion()
{

    //Si el log no existe
    if (!isset($_SESSION['login']) || $_SESSION['login'] === false) {

        $login = false;

        //Redirecciono al usuario
        header('Location: /');

    }else{

        $login = true;

    }

    return $login;

}

//SANITIZAR el HTML
function s($html): string
{

    $s = htmlspecialchars($html);
    return $s;
}

//VALIDAR tipo de contenido
function validarTipoContenido($tipo)
{

    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

//VALIDAR URL
function validarURL($url)
{

    $ID = $_GET['id'] ?? null;
    $ID = filter_var($ID, FILTER_VALIDATE_INT);

    if (!$ID) {

        //Redireccionar al usuario
        header("Location: $url");
    }

    return $ID;
}
