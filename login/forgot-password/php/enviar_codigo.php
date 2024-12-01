<?php
error_log("🚀 Iniciando proceso de envío de código");

require '../../../vendor/autoload.php';
require '../../../conexion_BD/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = sprintf("%05d", rand(0, 99999));
    
    error_log("📧 Email recibido: " . $email);
    error_log("🎲 Token generado: " . $token);
    
    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        error_log("🔌 Conexión a BD establecida");
        
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
        $stmt->execute([$email]);
        error_log("🔍 Buscando email en BD");
        
        if ($stmt->rowCount() > 0) {
            error_log("✅ Email encontrado en BD");
            
            $stmt = $pdo->prepare("UPDATE usuario SET token_recuperacion = ?, token_recuperacion_verificado = FALSE WHERE correo = ?");
            $stmt->execute([$token, $email]);
            error_log("💾 Token guardado en BD");
            
            $mail = new PHPMailer(true);
            
            try {
                // Debug
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->Debugoutput = function($str, $level) {
                    error_log("DEBUG: $str");
                };

                // Configuración
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bingosauro964@gmail.com'; // CAMBIA ESTO
                $mail->Password = 'ioyb iqob rpac ngls'; // CAMBIA ESTO - Contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->CharSet = 'UTF-8';

                // Remitente y destinatario
                $mail->setFrom('bingosauro964@gmail.com', 'Bingo Sauro'); // CAMBIA ESTO
                $mail->addAddress($email);

                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Código de recuperación - Bingo Sauro';
                
                $mail->Body = "
                <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
                    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;'>
                        <div style='background-color: #4e9c81; padding: 30px; text-align: center;'>
                            <h1 style='color: #ffffff; margin: 0; font-size: 28px;'>Código de Recuperación</h1>
                        </div>
                        <div style='padding: 40px 20px; text-align: center;'>
                            <h2 style='color: #333333; margin-bottom: 20px; font-size: 24px;'>
                                Tu código de verificación es:
                            </h2>
                            <div style='background-color: #f8f8f8; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                                <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4e9c81;'>
                                    {$token}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>";

                $mail->send();
                error_log("📨 Intentando enviar email");
                
                echo json_encode(['success' => true]);
                error_log("✅ Proceso completado exitosamente");
            } catch (Exception $e) {
                error_log("Error de PHPMailer: " . $mail->ErrorInfo);
                echo json_encode(['success' => false, 'message' => "Error al enviar el correo: " . $mail->ErrorInfo]);
            }
        } else {
            error_log("❌ Email no encontrado en BD");
            echo json_encode(['success' => false, 'message' => 'Correo no encontrado']);
        }
    } catch (Exception $e) {
        error_log("🚫 Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?> 