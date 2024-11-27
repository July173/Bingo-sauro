<?php
error_log("🚀 Iniciando actualización de contraseña");

require '../../../conexion_BD/conexion.php';
header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que el código haya sido validado
    if (!isset($_SESSION['codigo_verificado']) || !$_SESSION['codigo_verificado']) {
        error_log("❌ Intento de cambio de contraseña sin verificación");
        echo json_encode(['success' => false, 'message' => 'Proceso de verificación incompleto']);
        exit;
    }

    $email = $_SESSION['email_recuperacion'];
    $nueva_contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    
    error_log("📧 Email para actualización: " . $email);
    
    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        // Verificar que el token esté verificado
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE correo = ? AND token_recuperacion_verificado = TRUE LIMIT 1");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            // Actualizar la contraseña
            $stmt = $pdo->prepare("
                UPDATE usuario 
                SET contrasena = ?,
                    token_recuperacion = NULL,
                    token_recuperacion_verificado = FALSE 
                WHERE correo = ?
            ");
            $stmt->execute([$nueva_contrasena, $email]);
            
            // Limpiar la sesión
            unset($_SESSION['codigo_verificado']);
            unset($_SESSION['email_recuperacion']);
            
            error_log("✅ Contraseña actualizada correctamente");
            echo json_encode(['success' => true]);
        } else {
            error_log("❌ No autorizado para cambiar contraseña");
            echo json_encode(['success' => false, 'message' => 'No autorizado para cambiar la contraseña']);
        }
        
    } catch (Exception $e) {
        error_log("🚫 Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
    }
}
?> 