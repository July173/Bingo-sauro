<?php
session_start();
require_once '../../conexion_BD/conexion.php'; 

header('Content-Type: application/json');

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Validar que los campos no estén vacíos
    if (empty($_POST['nuevo_correo']) || empty($_POST['confirmar_correo'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    $nuevo_correo = trim($_POST['nuevo_correo']);
    $confirmar_correo = trim($_POST['confirmar_correo']);

    // Validar formato de correo
    if (!filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato del correo electrónico no es válido');
    }

    // Validar que los correos coincidan
    if ($nuevo_correo !== $confirmar_correo) {
        throw new Exception('Los correos no coinciden');
    }

    // Verificar que el correo no esté en uso
    $conexion = new Conexion();
    $query_check = "SELECT COUNT(*) as count FROM usuario WHERE correo = :correo AND id_usuario != :usuario_id";
    $params_check = [
        ':correo' => $nuevo_correo,
        ':usuario_id' => $_SESSION['usuario_id']
    ];
    $resultado = $conexion->select($query_check, $params_check);

    if ($resultado[0]['count'] > 0) {
        throw new Exception('Este correo electrónico ya está en uso');
    }

    // Actualizar el correo
    $query_update = "UPDATE usuario SET correo = :correo WHERE id_usuario = :usuario_id";
    $params_update = [
        ':correo' => $nuevo_correo,
        ':usuario_id' => $_SESSION['usuario_id']
    ];

    if ($conexion->update($query_update, $params_update)) {
        // Destruir la sesión actual
        session_destroy();
        
        echo json_encode([
            'success' => true,
            'mensaje' => 'Correo actualizado correctamente'
        ]);
    } else {
        throw new Exception('Error al actualizar el correo');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => $e->getMessage()
    ]);
}
?> 