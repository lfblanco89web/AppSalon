<?php

namespace MVC;

class Router {

    //DEFINICION de Rutas
    public $rutasGET = [];
    public $rutasPOST = [];

    //METODO get
    public function get($url, $fn){

        $this->rutasGET[$url] = $fn;

    }

    //METODO post
    public function post($url, $fn){

        $this->rutasPOST[$url] = $fn;

    }
    
    //METODO para Comprobar Rutas
    public function comprobarRutas(){

        //INICIO la Sesión
        session_start();

        $auth = $_SESSION['login'] ?? false;

        //ARREGLO de Rutas Protegidas
        $rutas_protegidas = ['/admin','/propiedades/crear', '/propiedades/actualizar', '/vendedores/crear', '/vendedores/actualizar'];

        //URL del Navegador
        
        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        
        //$urlActual = $_SERVER['PATH_INFO'] ?? '/';

        //METODO de comunicacion
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === "GET"){

            $fn = $this->rutasGET[$urlActual] ?? null;

        }else{

            $fn = $this->rutasPOST[$urlActual] ?? null;

        }

        //PROTEGER Rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){/*Si el usuario está en una ruta protegida y NO está autenticado*/

            header("Location: /");

        }


        //Si la ruta existe
        if($fn){

            //Llamo a la función asociada
            call_user_func($fn, $this);


        }else{

            //Redirecciono a Página de Error
            echo "Página 404";

        }

    }

    //METODO para Renderizar Vistas
    public function render($view, $datos = []){

        //REGISTRO los Datos
        foreach($datos as $key => $value){

            $$key = $value;

        }


        //ALMACENAR en Memoria
        ob_start();

        //VISTA
        include __DIR__ . "/views/$view.php";

        //ASIGNAR a variable y Liberar Memoria
        $contenido = ob_get_clean();      

        //PAGINA Maestra
        include __DIR__ . "/views/layout.php";
        

    }



}