<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener datos del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];

    // Eliminar al usuario de la tabla usuario_partida_rol
    $queryEliminar = "DELETE FROM usuario_partida_rol WHERE id_usuario = ?";
    $conexion->delete($queryEliminar, [$id_usuario]);

    echo json_encode(['success' => true, 'message' => 'Has salido de la partida.']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>
