<?php

namespace Model;

class ActiveRecord{

    //DEFINICION de atributos de la Base de Datos
    protected static $db;
    protected static $columnasDB = [];

    //DEFINICION de atributos para ActiveRecords
    protected static $vista = ''; /*Vista de la DB*/
    protected static $procedimiento = ''; /*Procedimiento CRUD*/

    //DEFINICION de atributos de Alertas
    protected static $alertas = [];



    //METODO Conectar a la DB
    public static function setDB($database){

        self::$db = $database;

    }

    //Carga de Imagen
    public function setImage($imagen){

        //Elimina la imagen previa
        if(!is_null($this->ID)){

           $this->delImage();

        }

        //Si la imagen existe
        if($imagen){

            //Creamos el atributo imagen
            $this->IMAGEN = $imagen;

        }

    }

    //Elimina Imagen
    public function delImage(){

        //Reviso la existencia del archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->IMAGEN);

        if($existeArchivo){/*Si existe*/

            //Se elimina
            unlink(CARPETA_IMAGENES . $this->IMAGEN);

        }

    }

    //METODO Construir Atributos
    public function atributos(){

        $atributos = [];

        //Se crea un arreglo a partir de los atributos del objeto

        foreach(static::$columnasDB as $columna){

            if($columna === 'ID') continue;
            $atributos[$columna] = $this->$columna;

        }

        return $atributos;

    }

    //METODO Sanitizar Datos
    public function sanitizar(){

        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            
            if(!($value === null)){

                $sanitizado[$key] = self::$db->escape_string($value);

            }

        }

        return $sanitizado;

    }

    //METODO validar Datos
    public function validar(){

        //Limpio el arreglo de alertas
        static::$alertas = [];

        return static::$alertas;

    }

    //METODO mostrar Alertas
    public static function getAlertas(){

        return static::$alertas;

    }

    //METODO Guardar
    public function guardar(){

        $resultado = '';

        //Si el ID existe
        if(!is_null($this->ID)){/*Actualizar*/

            $resultado = $this->actualizar();

        }else{/*Crear*/

            $resultado = $this->crear();

        }

        return $resultado;

    }

    //METODO Crear
    public function crear(){

        //Sanitizar los datos
        $atributos = $this->sanitizar();

        //Preparar llamada a la Base de Datos
        $query = "CALL " . static::$procedimiento . "(NULL, '";
        $query .= join("', '" ,array_values($atributos));
        $query .= "', 'c');";

        $resultado = self::$db->query($query);

        //Respuesta de la Base de Datos
        $registro = $resultado->fetch_assoc();

        $status = $registro['@_status'];
        $message = $registro['@_mensaje'];

        if($resultado) {

            if($status === 'success'){

                self::$alertas['success'][] = $message;

            } else {

                self::$alertas['error'][] = $message;

            }

            return self::$alertas;

        }

    }

    //METODO Actualizar
    public function actualizar(){

        //Sanitizar los datos
        $atributos = $this->sanitizar();

        //Preparar llamada a la Base de Datos
        
        $query = "CALL " . static::$procedimiento . "('" . self::$db->escape_string($this->ID) . "', '";
        $query .= join("', '" ,array_values($atributos));
        $query .= "', 'u');";

        //Ejecuto Consulta
        $resultado = self::$db->query($query);

        //Respuesta de la Base de Datos
        $registro = $resultado->fetch_assoc();

        $status = $registro['@_status'];
        $message = $registro['@_mensaje'];

        if($status === 'success'){

            self::$alertas['success'][] = $message;

        } else {

            self::$alertas['error'][] = $message;

        }

        return self::$alertas;

    }

    //METODO Eliminar
    public function eliminar(){

        //Sanitizar los datos
        $atributos = $this->sanitizar();

        //Se elimina la propiedad
        $query = "CALL " . static::$procedimiento . "(" . self::$db->escape_string($this->ID) . ", '";
        $query .= join("', '" ,array_values($atributos));
        $query .= "', 'd');";

        $resultado = self::$db->query($query);

        //Respuesta de la Base de Datos
        $registro = $resultado->fetch_assoc();

        $status = $registro['@_status'];
        $codigo = $registro['@_codigo'];
        $message = $registro['@_mensaje'];

        if($resultado){

            //Se elimina la imagen
            $this->delImage();

            //Redireccionar al usuario
            header("Location: /admin?s=$status&m=$message");

        }

    }

    //METODO Crear Objetos SQL
    protected static function crearObjetoSQL($registro){

        $objeto = new static; /*Nuevo Objeto Propiedad*/

        //Genero el objeto
        foreach($registro as $key => $value){

            $objeto->$key = $value;

        }

        return $objeto;

    }

    //METODO Consultar en la Base de Datos
    public static function consultarSQL($query){
        
        //CONSULTAR
        $resultado = self::$db->query($query);

        

        //ITERAR
        $array = []; /*Creo el Array*/

        while($registro = $resultado->fetch_assoc()){ /*Completo el array*/

            $array[] = static::crearObjetoSQL($registro);

        }

        //Liberar Memoria
        $resultado->free();

        //Retornar
        return $array;

    }

    //METODO Consultar todas las propiedades
    public static function all(){

        //Consultar
        $query = "SELECT * FROM " . static::$vista;

        //Crear Objetos
        $resultado = self::consultarSQL($query);

        //Mostrar resultados como objetos
        return $resultado;

    }

    //METODO Consulta UN registro por su ID
    public static function find($ID){

        //Consultar
        $query = "SELECT * FROM " . static::$vista . " WHERE ID = " . $ID;

        //Crear Objetos
        $resultado = self::consultarSQL($query);

        //Mostrar resultados como objetos
        return array_shift($resultado);

    }

    //METODO Consultar X cantidad de registros
    public static function findLimit($num){

        //Consultar
        $query = "SELECT * FROM " . static::$vista . " LIMIT " . $num;

        //Crear Objetos
        $resultado = self::consultarSQL($query);

        //Mostrar resultados como objetos
        return $resultado;

    }

    //METODO Consulta UN Registro por su UNA Columna de la Vista
    public static function where($columna, $valor){

        //Consultar
        $query = "SELECT * FROM " . static::$vista . " WHERE " . $columna . " = '${valor}';";

        //Crear Objetos
        $resultado = self::consultarSQL($query);

        //Mostrar resultados como objetos
        return array_shift($resultado);

    }

    //METODO Sincronizar objeto
    public function sincronizar( $args = []){

        //Reviso cada atributo del objeto
        foreach($args as $key => $value){

            //Si el atributo existe y no es nulo lo comparo con el inicial
            if(property_exists($this, $key) && !is_null($value)){

                //Reescribo el arreglo
                $this->$key = $value;

            }

        }

    }

    //METODO para Verificar Token
    public static function verificarToken($token){

        $registro = [];

        //CONSULTA
        $query = "CALL verificar_email('${token}');";
        
        //EJECUTAR Consulta
        $resultado = self::$db->query($query);

        //RESPUESTA de la Base de Datos
        $registro = $resultado->fetch_assoc() ?? null;

        //GENERO Alertas
        if(!empty($registro)) {

            $status = $registro["@_status"] ?? null;
            $message = $registro["@_mensaje"] ?? null;

            if($status === 'success'){

                self::$alertas['success'][] = $message;

            } else {

                self::$alertas['error'][] = $message;

            }

            return self::$alertas;

        }

    }


}