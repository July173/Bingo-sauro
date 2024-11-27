<?php
error_log("🚀 Iniciando verificación de código");

require '../../../conexion_BD/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    
    error_log("📧 Email recibido: " . $email);
    error_log("🔑 Código ingresado: " . $codigo);
    
    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();
        
        // Obtener el código almacenado para este email
        $stmt = $pdo->prepare("SELECT token_recuperacion FROM usuario WHERE correo = ?");
        $stmt->execute([$email]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("💾 Código almacenado en BD: " . ($resultado ? $resultado['token_recuperacion'] : 'No encontrado'));
        
        if ($resultado && $resultado['token_recuperacion'] === $codigo) {
            error_log("✅ Código coincide");
            
            // Marcar como verificado
            $stmt = $pdo->prepare("UPDATE usuario SET token_recuperacion_verificado = TRUE WHERE correo = ?");
            $stmt->execute([$email]);
            
            // Iniciar sesión y guardar datos
            session_start();
            $_SESSION['codigo_verificado'] = true;
            $_SESSION['email_recuperacion'] = $email;
            
            echo json_encode(['success' => true]);
            error_log("✅ Verificación completada exitosamente");
        } else {
            error_log("❌ Código no coincide");
            echo json_encode([
                'success' => false, 
                'message' => 'Código inválido',
                'debug' => [
                    'codigo_ingresado' => $codigo,
                    'codigo_almacenado' => $resultado ? $resultado['token_recuperacion'] : null
                ]
            ]);
        }
        
    } catch (Exception $e) {
        error_log("🚫 Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
    }
} else {
    error_log("⚠️ Método no permitido");
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?> 