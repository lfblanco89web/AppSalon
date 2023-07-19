<?php

namespace Model;

class Cita extends ActiveRecord{

    //DEFINICION de atributos para ActiveRecords
    protected static $procedimiento = 'administrar_cita_crud'; /*Procedimiento CRUD*/

    /*DEFINICION Columnas de la Vista*/
    protected static $columnasDB = ['FECHA', 'HORA', 'USUARIO', 'CRUD'];

    //DEFINICION de atributos del Objeto
    public $FECHA;
    public $HORA;
    public $USUARIO;
    public $CRUD;

    //CONSTRUCTOR del Objeto
    public function __construct($args = [])
    {
        $this->FECHA = $args['FECHA'] ?? null;
        $this->HORA = $args['HORA'] ?? '';
        $this->USUARIO = $args['USUARIO'] ?? '';
        $this->CRUD = $args['CRUD'] ?? '';

    }

    public function reservar(){

        $db = self::$db;

        //LIBERAR MEMORIA
        while ($db->more_results() && $db->next_result()) {
            $db->use_result();
        }

        $procedimiento = self::$procedimiento;

        $query = "CALL $procedimiento ('$this->FECHA', '$this->HORA', '$this->USUARIO', 'c');";

        $resultado = $db->query($query);
        $resultado = $resultado->fetch_assoc();

        $respuesta = $resultado;

        return $respuesta;

    }

}