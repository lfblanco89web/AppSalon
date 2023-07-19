<?php

    function conectarDB() : mysqli{

        $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

        //Si no se pudo establecer conexión
        if(!$db){

            echo "Error no se pudo establecer conexión a la Base de Datos";
            exit;

        }

        return $db;

    }