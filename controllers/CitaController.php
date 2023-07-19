<?php

namespace Controllers;

//MODELOS
use MVC\Router;

//CONTROLADOR
class CitaController{

    //METODO para Index
    public static function index(Router $router){

        $login = autenticacion();

        //VISTA
        $router->render('cita/index',[

            'NOMBRE' => $_SESSION['NOMBRE'] ?? null,
            'login' => $login

        ]);

    }

}