<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];

    // Verificar si el usuario está en la tabla usuario_partida_rol
    $query = "SELECT COUNT(*) as total FROM usuario_partida_rol WHERE id_usuario = ?";
    $result = $conexion->select($query, [$id_usuario]);

    if ($result[0]['total'] > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuario sigue en la partida.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no está en la partida.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>