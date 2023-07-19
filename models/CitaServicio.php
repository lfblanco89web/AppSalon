<?php

namespace Model;

class CitaServicio extends ActiveRecord
{

    //DEFINICION de atributos para ActiveRecords
    protected static $procedimiento = 'administrar_servicios_citas'; /*Procedimiento CRUD*/

    /*DEFINICION Columnas de la Vista*/
    protected static $columnasDB = ['CITA', 'SERVICIO', 'CRUD'];

    //DEFINICION de atributos del Objeto
    public $CITA;
    public $SERVICIO;
    public $CRUD;

    public function agregarServicio(){

        $db = self::$db;

        //LIBERAR MEMORIA
        while ($db->more_results() && $db->next_result()) {
            $db->use_result();
        }

        $procedimiento = self::$procedimiento;

        $query = "CALL $procedimiento ('$this->CITA', '$this->SERVICIO', 'c');";

        $resultado = $db->query($query);
        $resultado = $resultado->fetch_assoc();

        $respuesta = $resultado;

        return $respuesta;

    }

}
