<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Depuración de datos recibidos
    error_log("POST recibido: " . print_r($_POST, true));
    
    // Validar que los campos no estén vacíos
    if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
        throw new Exception('Los campos correo y contraseña son requeridos');
    }

    require_once 'inicio.php';
    
    $inicio = new inicio();
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);
    
    // Log de los datos que se van a validar
    error_log("Intentando validar - Correo: $correo");
    
    // Validar credenciales
    $resultado = $inicio->validarCredenciales($correo, $contrasena);
    
    // Log del resultado
    error_log("Resultado de la validación: " . print_r($resultado, true));
    
    // Si las credenciales son válidas, iniciar sesión
    if ($resultado['validas']) {
        // Almacenar la información del usuario en la sesión
        session_start();  // Asegurarse de que la sesión esté iniciada
        $_SESSION['usuario_id'] = $resultado['usuario']['id_usuario'];  // Guardar nombre del usuario
        $_SESSION['correo'] = $resultado['usuario']['correo'];  // Guardar correo del usuario
        $_SESSION['nombre'] = $resultado['usuario']['nombre'];  // Guardar nombre del usuario
        
        // Opcional: También podrías agregar más datos si es necesario, por ejemplo, el id del usuario
    }
    
    // Asegurarse de que no haya salida antes del JSON
    if (ob_get_length()) ob_clean();
    
    // Enviar respuesta al cliente
    echo json_encode($resultado);
    exit(); // Asegurarse de que no haya más salida después
    
} catch (Exception $e) {
    error_log("Error en ingreso.php: " . $e->getMessage());
    if (ob_get_length()) ob_clean();
    echo json_encode([
        'validas' => false,
        'mensaje' => $e->getMessage()
    ]);
    exit();
}
?>