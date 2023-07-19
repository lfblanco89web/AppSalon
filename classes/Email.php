<?php

namespace Classes;

//COMPOSER
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $EMAIL;
    public $NOMBRE;
    public $APELLIDO;
    public $TOKEN;

    //CONSTRUCTOR del Objeto
    public function __construct($EMAIL, $NOMBRE, $APELLIDO, $TOKEN)
    {

        $this->EMAIL = $EMAIL;
        $this->NOMBRE = $NOMBRE;
        $this->APELLIDO = $APELLIDO;
        $this->TOKEN = $TOKEN;

    }

    //METODO para Enviar EMAIL
    public function enviarConfirmacion(){

        //CREAR el OBJETO
        $mail = new PHPMailer();

        //CONFIGURAR PHPMailer
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        //PARAMETROS del Mail
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon');
        $mail->Subject = 'Confirma tu cuenta en AppSalon';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //CUERPO del Mail
        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->NOMBRE . " " . $this->APELLIDO . "</strong></p>";
        $contenido .=  "<p>Has creado tu cuenta en AppSalon solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí <a href='" . $_ENV['APP_URL'] . "/confirmar?token=". $this->TOKEN ."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste la cuenta, puedes desestimar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAR el Mail
        $mail->send();

    }

    //METODO para Enviar EMAIL de Recuperación
    public function enviarInstrucciones(){

        //CREAR el OBJETO
        $mail = new PHPMailer();

        //CONFIGURAR PHPMailer
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b1bcc05cbdcdd0';
        $mail->Password = 'd26b4951fe80ef';

        //PARAMETROS del Mail
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon');
        $mail->Subject = 'Reestablece tu Password en AppSalon';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //CUERPO del Mail
        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->NOMBRE . " " . $this->APELLIDO . "</strong></p>";
        $contenido .=  "<p>Has solicitado restablecer tu Password en AppSalon, sigue el siguiente enlace para haerlo.</p>";
        $contenido .= "<p>Presiona aquí <a href='" . $_ENV['APP_URL'] . "/recuperar?token=". $this->TOKEN ."'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste la cuenta, puedes desestimar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAR el Mail
        $mail->send();

    }


}