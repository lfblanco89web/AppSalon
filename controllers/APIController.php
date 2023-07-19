<?php

namespace Controllers;

//MODELOS
use MVC\Router;
use Model\Servicio;
use Model\CitaServicio;
use Model\Cita;

//CONTROLADOR
class APIController{

    //METODO General
    public static function index(){

        //CONSULTAR Todos los Servicios Disponibles
        $servicios = Servicio::all();
        echo json_encode($servicios);
        
    }

    //METODO Guardar una Cita en la Base de Datos
    public static function guardar(){

        //GENERA La Cita
        $cita = new Cita($_POST);
        $cita->USUARIO = $_SESSION['ID'] ?? $_POST['USUARIO'];

        $reserva = $cita->reservar();

        if(!isset($reserva['RESERVA'])){

            return $reserva;

        }

        $idCita = $reserva['RESERVA'];
        $idServicios = explode(",", $_POST['SERVICIOS']);

        foreach ($idServicios as $idServicio){

            $CitaServicio = new CitaServicio();
            
            $CitaServicio->CITA = $idCita;
            $CitaServicio->SERVICIO = $idServicio;

            $resultado = $CitaServicio->agregarServicio();

        }

        //ALMACENA los Servicios
        echo json_encode($reserva);
        return $reserva;

    }


}