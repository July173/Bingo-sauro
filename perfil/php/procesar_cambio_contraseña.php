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
    if (empty($_POST['password_actual']) || empty($_POST['password_nuevo']) || empty($_POST['password_confirmar'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    $password_actual = $_POST['password_actual'];
    $password_nuevo = $_POST['password_nuevo'];
    $password_confirmar = $_POST['password_confirmar'];

    // Validar longitud mínima
    if (strlen($password_nuevo) < 8) {
        throw new Exception('La contraseña debe tener al menos 8 caracteres');
    }

    // Validar que contenga al menos un número
    if (!preg_match('/[0-9]/', $password_nuevo)) {
        throw new Exception('La contraseña debe contener al menos un número');
    }

    // Validar que las contraseñas nuevas coincidan
    if ($password_nuevo !== $password_confirmar) {
        throw new Exception('Las contraseñas nuevas no coinciden');
    }

    // Verificar la contraseña actual
    $conexion = new Conexion();
    $query = "SELECT contrasena FROM usuario WHERE id_usuario = :usuario_id";
    $params = [':usuario_id' => $_SESSION['usuario_id']];
    $resultado = $conexion->select($query, $params);

    if (!$resultado || !password_verify($password_actual, $resultado[0]['contrasena'])) {
        throw new Exception('La contraseña actual es incorrecta');
    }

    // Actualizar la contraseña
    $password_hash = password_hash($password_nuevo, PASSWORD_DEFAULT);
    $query_update = "UPDATE usuario SET contrasena = :password WHERE id_usuario = :usuario_id";
    $params_update = [
        ':password' => $password_hash,
        ':usuario_id' => $_SESSION['usuario_id']
    ];

    if ($conexion->update($query_update, $params_update)) {
        // Destruir la sesión actual
        session_destroy();
        
        echo json_encode([
            'success' => true,
            'mensaje' => 'Contraseña actualizada correctamente'
        ]);
    } else {
        throw new Exception('Error al actualizar la contraseña');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => $e->getMessage()
    ]);
}
?> 