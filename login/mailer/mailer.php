<?php
// Carga de dependencias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Verificar que el archivo existe antes de requerirlo
if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    error_log("Error: No se encuentra el archivo vendor/autoload.php");
    throw new Exception("Error en la configuración del correo.");
}

function enviarCorreoBienvenida($emailDestino, $nombreDestino, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bingosauro964@gmail.com';
        $mail->Password = 'ioyb iqob rpac ngls'; // Cambia esto a tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  
        $mail->CharSet = 'UTF-8';

        // Configuración del correo
        $mail->setFrom('bingosauro964@gmail.com', 'Bingo Sauro');
        $mail->addAddress($emailDestino, $nombreDestino);
        
        $mail->isHTML(true);
        $mail->Subject = '¡Bienvenido a Bingo Sauro! 🦖';

        // URL de verificación usando una ruta relativa
        $urlVerificacion = "http://localhost/Bingo-sauro/login/verificar.php?token=" . urlencode($token); // Cambia 'localhost' si es necesario

        // Cuerpo del correo
        $mail->Body = "
        <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;'>
                <!-- Header -->
                <div style='background-color: #4e9c81; padding: 30px; text-align: center;'>
                    <h1 style='color: #ffffff; margin: 0; font-size: 28px;'>Bingo Sauro</h1>
                </div>

                <!-- Contenido principal -->
                <div style='padding: 40px 20px; text-align: center;'>
                    <h2 style='color: #333333; margin-bottom: 20px; font-size: 24px;'>
                        ¡Hola, {$nombreDestino}! 🎉
                    </h2>

                    <p style='color: #666666; font-size: 16px; line-height: 1.5; margin-bottom: 30px;'>
                        Gracias por registrarte en Bingo Sauro. Para completar tu registro y comenzar a jugar,
                        por favor verifica tu cuenta haciendo clic en el siguiente botón:
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
                              box-shadow: 0 3px 6px rgba(0,0,0,0.1);'>
                        Confirmar Registro
                    </a>

                    <p style='color: #999999; font-size: 14px; margin-top: 30px;'>
                        Si el botón no funciona, copia y pega este enlace en tu navegador:
                    </p>
                    <p style='color: #666666; font-size: 12px; word-break: break-all;'>
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
