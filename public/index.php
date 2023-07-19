<?php

    //REQUIRES
    require_once __DIR__ . '/../includes/app.php';

    //MVC
    use MVC\Router;

    //CONTROLLERS
    use Controllers\LoginController;
    use Controllers\CitaController;
    use Controllers\APIController;

    //OBJETO
    $router = new Router();

    //DEFINICION de Rutas GET
        //LOGIN
        $router->get('/', [LoginController::class, 'login']);
        $router->get('/logout', [LoginController::class, 'logout']);

        $router->get('/olvide', [LoginController::class, 'olvide']);
        $router->get('/recuperar', [LoginController::class, 'recuperar']);
        $router->get('/confirmar', [LoginController::class, 'confirmar']);

        $router->get('/crear-cuenta', [LoginController::class, 'crear']);

        //AREA PRIVADA
        $router->get('/cita', [CitaController::class, 'index']);

        //API de Citas
        $router->get('/api/servicios', [APIController::class, 'index']);
        $router->post('/api/citas', [APIController::class, 'guardar']);

    //DEFINICION de Rutas POST
        //LOGIN
        $router->post('/', [LoginController::class, 'login']);

        $router->post('/olvide', [LoginController::class, 'olvide']);
        $router->post('/recuperar', [LoginController::class, 'recuperar']);

        $router->post('/crear-cuenta', [LoginController::class, 'crear']);

        //AREA PRIVADA
        $router->post('/cita', [CitaController::class, 'index']);

        //API de Citas


    //Comprobar Rutas Creadas
    $router->comprobarRutas();