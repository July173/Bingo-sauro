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
    
    $resultado = $inicio->validarCredenciales($correo, $contrasena);
    
    // Log del resultado
    error_log("Resultado de la validación: " . print_r($resultado, true));
    
    echo json_encode($resultado);
    
} catch (Exception $e) {
    error_log("Error en ingreso.php: " . $e->getMessage());
    echo json_encode([
        'validas' => false,
        'mensaje' => $e->getMessage()
    ]);
}
?> 