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
        
        // URL de verificación
        $urlVerificacion = "http://tudominio.com/login/verificar.php?token=" . $token;
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirma tu registro en Bingo Sauro';
        $mail->Body = "
            <h1>¡Bienvenido {$nombreDestino}!</h1>
            <p>Gracias por querer formar parte de Bingo Sauro.</p>
            <p>Para completar tu registro, por favor haz clic en el siguiente botón:</p>
            <p style='text-align: center;'>
                <a href='http://localhost/Bingo-sauro/login/verificar.php?token={$token}' 
                   style='background-color: #4CAF50; 
                          color: white; 
                          padding: 14px 25px; 
                          text-align: center; 
                          text-decoration: none; 
                          display: inline-block; 
                          border-radius: 15px;
                          margin: 20px 0;'>
                    Confirmar Registro
                </a>
            </p>
            <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
            <p>http://localhost/Bingo-sauro/login/verificar.php?token={$token}</p>";
            
        $mail->AltBody = "Bienvenido {$nombreDestino}! Para confirmar tu registro, visita: {$urlVerificacion}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        throw new Exception("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}
?>
