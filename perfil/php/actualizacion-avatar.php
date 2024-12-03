<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario y el ID del avatar
    $id_usuario = $_SESSION['usuario_id'];
    $id_avatar = $_POST['id_avatar'];

    // Instanciar la clase Conexion
    $conexion = new Conexion();

    // Consulta SQL para actualizar el avatar del usuario
    $query = "UPDATE usuario SET id_avatar = :id_avatar WHERE id_usuario = :id_usuario";

    // Ejecutar la consulta
    $conexion->update($query, ['id_avatar' => $id_avatar, 'id_usuario' => $id_usuario]);

    // Responder con un mensaje de éxito
    echo json_encode(['status' => 'success', 'message' => 'Avatar actualizado correctamente.']);
} catch (Exception $e) {
    // En caso de error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
