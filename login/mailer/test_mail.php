<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bingosauro964@gmail.com'; // Cambia esto a tu correo
    $mail->Password = 'ioyb iqob rpac ngls'; // Cambia esto a tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('bingosauro964@gmail.com', 'Bingo Sauro');
    $mail->addAddress('medinafabriany@gmail.com', 'Reyving'); // Cambia esto al destinatario

    $mail->isHTML(true);
    $mail->Subject = 'Prueba de envío de correo';
    $mail->Body = 'Este es un correo de prueba.';

    $mail->send();
    echo 'Correo enviado con éxito';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?> 