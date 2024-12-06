<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado.');
    }

    $id_usuario = $_SESSION['usuario_id'];
    $codigo_partida = $_GET['codigoPartida'] ?? null;

    if (!$codigo_partida) {
        throw new Exception('Código de partida no proporcionado.');
    }

    // Obtener el número de cartones desde la base de datos
    $query = "SELECT numero_cartones FROM usuario_partida_rol WHERE id_usuario = ? AND codigo_sala = ?";
    $resultado = $conexion->select($query, [$id_usuario, $codigo_partida]);

    if (!$resultado || count($resultado) === 0) {
        throw new Exception('No se encontró la información del usuario en la partida.');
    }

    $numero_cartones = $resultado[0]['numero_cartones'];

    // Retornar el número de cartones al frontend
    echo json_encode(['success' => true, 'numero_cartones' => $numero_cartones]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
