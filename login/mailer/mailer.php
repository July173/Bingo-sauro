<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function enviarCorreoBienvenida($emailDestino, $nombreDestino, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bingosauro964@gmail.com';
        $mail->Password = 'ioyb iqob rpac ngls';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  
        $mail->CharSet = 'UTF-8';

        // Configuración del correo
        $mail->setFrom('bingosauro964@gmail.com', 'Bingo Sauro');
        $mail->addAddress($emailDestino, $nombreDestino);
        
        $mail->isHTML(true);
        $mail->Subject = '¡Bienvenido a Bingo Sauro! 🦖';

        // URL de verificación
        $urlVerificacion = "http://localhost/Bingo-sauro/login/verificar.php?token=" . $token;

        // Plantilla HTML del correo
        $mail->Body = "
        <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;'>
                <!-- Header con imagen de banner -->
                <div style='background-color: #4e9c81; padding: 20px; text-align: center;'>
                    <img src='https://i.ibb.co/VvCPKXw/bingo.png' alt='Bingo Sauro Logo' style='max-width: 200px;'>
                </div>

                <!-- Contenido principal -->
                <div style='padding: 40px 20px; text-align: center;'>
                    <h1 style='color: #333333; margin-bottom: 20px; font-size: 24px;'>
                        ¡Bienvenido a Bingo Sauro, {$nombreDestino}! 🎉
                    </h1>

                    <!-- Imagen de dinosaurio -->
                    <img src='https://i.ibb.co/mX3W0vK/dino-Registro.png' alt='Dinosaurio' style='max-width: 150px; margin: 20px 0;'>

                    <p style='color: #666666; font-size: 16px; line-height: 1.5; margin-bottom: 30px;'>
                        Estamos emocionados de tenerte con nosotros. Solo falta un paso más para comenzar la diversión.
                    </p>

                    <!-- Botón de verificación -->
                    <a href='{$urlVerificacion}' 
                       style='display: inline-block;
                              background-color: #4e9c81;
                              color: #ffffff;
                              text-decoration: none;
                              padding: 15px 30px;
                              border-radius: 50px;
                              font-size: 16px;
                              font-weight: bold;
                              margin: 20px 0;
                              transition: background-color 0.3s;'>
                        Confirmar Registro
                    </a>

                    <p style='color: #999999; font-size: 14px; margin-top: 30px;'>
                        Si el botón no funciona, copia y pega este enlace en tu navegador:
                    </p>
                    <p style='color: #666666; font-size: 12px;'>
                        {$urlVerificacion}
                    </p>
                </div>

                <!-- Footer -->
                <div style='background-color: #f8f8f8; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;'>
                    <p style='color: #999999; font-size: 12px; margin: 0;'>
                        © " . date('Y') . " Bingo Sauro. Todos los derechos reservados.<br>
                        Este es un correo automático, por favor no respondas a este mensaje.
                    </p>
                </div>
            </div>
        </div>";

        // Versión texto plano
        $mail->AltBody = "¡Bienvenido a Bingo Sauro, {$nombreDestino}!
        Para verificar tu cuenta, visita: {$urlVerificacion}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo: " . $e->getMessage());
        throw new Exception("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}
?>