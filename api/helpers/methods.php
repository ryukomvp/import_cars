<?php
/*
*	Clase para validar todos los datos de entrada del lado del servidor.
*/

// Se incluye la clase para la transferencia y acceso a datos.
//libreria phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Methods
{

    /*
    *   Método para enviar un correo.
    *   Parámetros: $email (correo del receptor), $recipient (nombre del receptor), $codigoveri (codigo de verificación), $asunto (Asunto del correo), $cuerpo (Cuerpo del correo).
    */
    public static function enviarCorreo($email, $recipient, $codigoveri, $asunto, $cuerpo)
    {
        // Se envia un correo que contiene el código generado para iniciar sesión.
        $number = array();
        array_push($number, $codigoveri);
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->Username = 'importcars044@gmail.com'; // Correo del remitente.
        $mail->Password = 'hmppxvsafzohqlen'; //16 character obtained from app password created
        $mail->Port = 465; // puerto SMTP
        $mail->SMTPSecure = "ssl";
        // Información del remitente.
        $mail->setFrom('importcars044@gmail.com', 'importcars_004');
        // Información del receptor.
        $mail->addAddress($email, $recipient);
        $mail->isHTML(true);
        // Asunto del correo
        $mail->Subject = $asunto;
        // Cuerpo del correo
        $mail->Body = $cuerpo;
        // Se envia el correo 
        return $mail->send();
    }
}