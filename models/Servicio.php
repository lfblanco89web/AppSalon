<?php

namespace Model;

class Servicio extends ActiveRecord{

    //DEFINICION de atributos para ActiveRecords
    protected static $vista = 'servicios_v'; /*Vista de la DB*/
    protected static $procedimiento = ''; /*Procedimiento CRUD*/

    /*DEFINICION Columnas de la Vista*/
    protected static $columnasDB = ['ID', 'NOMBRE', 'PRECIO'];

    //DEFINICION de atributos del Objeto
    public $ID;
    public $NOMBRE;
    public $PRECIO;

    //CONSTRUCTOR del Objeto
    public function __construct($args = [])
    {
        $this->ID = $args['ID'] ?? null;
        $this->NOMBRE = $args['NOMBRE'] ?? '';
        $this->PRECIO = $args['PRECIO'] ?? '';

    }

}