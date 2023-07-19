<?php

    //INCLUIR Classes
    use Model\ActiveRecord;
    use Dotenv\Dotenv;

    require __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    require 'funciones.php';
    require 'config/database.php';
    

    //CONEXION a la Base de Datos
    $db = conectarDB();

    //CONECTAR Classe a la Base de Datos
    ActiveRecord::setDB($db);




