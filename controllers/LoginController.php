<?php

namespace Controllers;

//MODELOS
use MVC\Router;
use Model\Usuario;
use Classes\Email;

//CONTROLADOR
class LoginController{

    //METODO para LogIn
    public static function login(Router $router){

        //REVISAR Alertas
        if(!empty($alertas)){

            //Las muestro
            $alertas = Usuario::getAlertas();

        }else{

            //Genero un array vacio
            $alertas =[];

        }

        //CREAR Objeto
        $auth = new Usuario;

        //METODO POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //OBJETO
            $auth = new Usuario($_POST);
            
            //VALIDAR Campos
            $alertas = $auth->validarLogin();

            if(empty($alertas)){

                //VALIDAR Usuario
                $usuario = Usuario::where('EMAIL', $auth->EMAIL);

                if($usuario){

                    //VALIDAR Password
                    $alertas = $usuario->validarUsuario($auth->PASSWORD);

                    if($alertas === true){

                        //INICIAR Sesion
                        if(!$_SESSION){
                            
                            session_start();

                        }

                        $_SESSION['ID'] = $usuario->ID;
                        $_SESSION['NOMBRE'] = $usuario->NOMBRE . " " . $usuario->APELLIDO;
                        $_SESSION['EMAIL'] = $usuario->EMAIL;
                        $_SESSION['login'] = true;
                        
                        if($usuario->ADMIN === "1"){

                            $_SESSION['ADMIN'] = $usuario->ADMIN ?? null;
                            
                            header("Location: /admin");

                        }else{

                            header("Location: /cita");

                        }

                    }

                }else{

                    $alertas['error'][] = "El Usuario no existe";

                }

            }

        }

        //VISTA
        $router->render('auth/login',[

            'alertas'=> $alertas,
            'auth' => $auth

        ]);

    }

    //METODO para LogOut
    public static function logout(){
        echo "Desde LogOut";
    }
    
    //METODO para Recuperar Contraseña
    public static function olvide(Router $router){

        //ALERTAS
        $alertas = [];

        //METODO POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //OBJETO
            $auth = new Usuario($_POST);

            //VERIFICACION
            $alertas = $auth->validarEmail();

            if(empty($alertas)){

                //CONSULTAR la existencia del mail
                $usuario = Usuario::where('EMAIL', $auth->EMAIL);

                if($usuario){

                    //CONSULTAR la verificacion de cuenta
                    if($usuario->CONFIRMADO === "1"){

                        //GENERAR Token
                        $usuario->crearToken();

                        //ACTUALIZAR Usuario
                        $alertas = $usuario->guardar();

                        //ENVIAR E-mail
                        $email = new Email($usuario->EMAIL, $usuario->NOMBRE, $usuario->APELLIDO, $usuario->TOKEN);
                        $email->enviarInstrucciones();

                        //MOSTRAR Mensaje
                        if($alertas['success']){

                            $alertas = [];

                            $alertas['success'][] = "Revisa tu E-mail";

                        }

                    }else{

                        $alertas['error'][] = "El mail no se encuentra verificado";

                    }

                }else{

                    $alertas['error'][] = "El mail indicado no se encuentra registrado";

                }
    
            }

        }

        //VISTA
        $router->render('auth/olvide',[

            'alertas' => $alertas

        ]);
        
    }

    public static function recuperar(Router $router){

        //LIMPIAR Alertas
        $alertas = [];
        $error = false;
        
        //LEER el GET
        $TOKEN = s($_GET['token']);
        
        //CONSULTA sobre el Token
        $usuario = Usuario::where('TOKEN', $TOKEN);

        if(empty($usuario)){ /* Si el usuario no existe */

            $alertas['error'][] = "Token no Válido";
            $error = true;

        }else{

        //METODO POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //OBJETO
            $password = new Usuario($_POST);

            //VALIDAR Password
            $alertas = $password->validarPassword();

            if(empty($alertas)){

                //ELIMINAR Password anterior
                $usuario->PASSWORD = null;

                //GENERRAR Password nuevo
                $usuario->PASSWORD = $password->PASSWORD;

                //HASH Password
                $usuario->hashPassword();

                //ELIMINAR Token
                $usuario->TOKEN = '';

                $resultado = $usuario->guardar();

                if($resultado){

                    header("Location: /");

                }

            }

        }

        }

        //VISTA
        $router->render('auth/recuperar',[

            'alertas' => $alertas,
            'error' => $error

        ]);
        
    }

    //METODO para Crear Usuario
    public static function crear(Router $router){

        //CREAR el OBJETO
        $usuario = new Usuario;
        
        //LIMPIAR las Alertas
        $alertas = [];

        //METODO POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //CREAR el nuevo objeto con los datos de POST
            $usuario->sincronizar($_POST);

            //VALIDACION de los Datos del POST
            $alertas = $usuario->validarNuevaCuenta();

                //Si no hay errores
                if(empty($alertas)){

                    //HASHEAR el Password
                    $usuario->hashPassword();

                    //GENERAR Token de seguridad
                    $usuario->crearToken();

                    //GUARDAR en la Base de Datos
                    $alertas = $usuario->guardar();

                    $status = array_key_last($alertas);

                    if($status === 'success'){

                        //ENVIAR email de Verificación
                        $email = new Email($usuario->EMAIL, $usuario->NOMBRE, $usuario->APELLIDO, $usuario->TOKEN);

                        $email->enviarConfirmacion();

                        //REDIRECCIONAR Usuario
                        $notificacion = $alertas["success"];

                        $mensaje = $notificacion[0];
                    
                        header("Location: /?s=success&m=${mensaje}");

                    }else{

                        $usuario->getAlertas();

                    }
        
                }
 
        }

        //VISTA
        $router->render('auth/crear',[

            'usuario' => $usuario,
            'alertas' => $alertas,

        ]);

    }

    //METODO para Confirmar email
    public static function confirmar(Router $router){

        //CREAR el OBJETO
        $usuario = new Usuario;
        
        //LIMPIAR las Alertas
        $alertas = [];
        $TOKEN = s($_GET['token']);

        //VERIFICAR Token
        Usuario::verificarToken($TOKEN);

        //VERIFICAR Mensajes
        $alertas = $usuario->getAlertas();

        //VISTA
        $router->render('auth/confirmar',[

            'alertas' => $alertas

        ]);

    }

}