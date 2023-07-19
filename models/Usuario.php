<?php

namespace Model;

class Usuario extends ActiveRecord{


    //DEFINICION de atributos para ActiveRecords
    protected static $vista = 'usuarios_v'; /*Vista de la DB*/
    protected static $procedimiento = 'usuarios_crud'; /*Procedimiento CRUD*/

    /*DEFINICION Columnas de la Vista*/
    protected static $columnasDB = ['ID', 'NOMBRE', 'APELLIDO', 'EMAIL','PASSWORD', 'TELEFONO', 'ADMIN', 'CONFIRMADO', 'TOKEN'];

    //DEFINICION de atributos del Objeto
    public $ID;
    public $NOMBRE;
    public $APELLIDO;
    public $EMAIL;
    public $PASSWORD;
    public $TELEFONO;
    public $ADMIN;
    public $CONFIRMADO;
    public $TOKEN;

    //CONSTRUCTOR del Objeto
    public function __construct($args = [])
    {
        $this->ID = $args['ID'] ?? null;
        $this->NOMBRE = $args['NOMBRE'] ?? '';
        $this->APELLIDO = $args['APELLIDO'] ?? '';
        $this->EMAIL = $args['EMAIL'] ?? '';
        $this->PASSWORD = $args['PASSWORD'] ?? '';
        $this->TELEFONO = $args['TELEFONO'] ?? '';
        $this->ADMIN = $args['ADMIN'] ?? 0;
        $this->CONFIRMADO = $args['CONFIRMADO'] ?? 0;
        $this->TOKEN = $args['TOKEN'] ?? '';

    }

    //METODO validar Datos para una Cuenta Nueva
    public function validarNuevaCuenta(){

        //Validación de variables
        if(!$this->NOMBRE){

            self::$alertas['error'][] = "El Nombre es obligatorio";

        }

        if(!$this->APELLIDO){

            self::$alertas['error'][] = "El Apellido es obligatorio";

        }

        if(!$this->EMAIL){

            self::$alertas['error'][] = "El E-mail es obligatorio";

        }

        if(!$this->PASSWORD){

            self::$alertas['error'][] = "El Password es obligatorio";

        }

        if(strlen($this->PASSWORD) < 6){

            self::$alertas['error'][] = "El Password debe tener al menos seis caracteres";

        }
        
        if(!$this->TELEFONO){

            self::$alertas['error'][] = "El Teléfono es obligatorio";

        }

        return self::$alertas;

    }

    //METODO validar Datos para una Cuenta Nueva
    public function validarLogin(){

        //Validación de variables
        if(!$this->EMAIL){

            self::$alertas['error'][] = "El E-mail es obligatorio";

        }

        if(!$this->PASSWORD){

            self::$alertas['error'][] = "El Password es obligatorio";

        }

        if(strlen($this->PASSWORD) < 6){

            self::$alertas['error'][] = "El Password debe tener al menos seis caracteres";

        }

        return self::$alertas;

    }

    //METODO validar Datos para una Cuenta Nueva
    public function validarPassword(){

        //Validación de variables
        if(!$this->PASSWORD){

            self::$alertas['error'][] = "El Password es obligatorio";

        }

        if(strlen($this->PASSWORD) < 6){

            self::$alertas['error'][] = "El Password debe tener al menos seis caracteres";

        }

        return self::$alertas;

    }

    //METODO para Validar Email
    public function validarEmail(){

        //Validación de variables
        if(!$this->EMAIL){

            self::$alertas['error'][] = "El E-mail es obligatorio";

        }

        return self::$alertas;

    }

    //METODO para Hashear Password
    public function hashPassword(){

        $this->PASSWORD = password_hash($this->PASSWORD, PASSWORD_BCRYPT);

    }

    //METODO para Crear Token
    public function crearToken(){

        $this->TOKEN = uniqid();

    }

    //METODO para Validar Usuario y Password
    public function validarUsuario($password){

        //VALIDAR Password
        $resultado = password_verify($password, $this->PASSWORD);
        
        if($resultado){

            //VALIDAR cuenta verificada
            if($this->CONFIRMADO == 1){

                //CUENTA Verificada
                return true;

            }else{

                self::$alertas['error'][] = "El mail no se encuentra verificado";

            }

        }else{

            self::$alertas['error'][] = "Password incorrecto";

        }

        return self::$alertas;

    }

}
