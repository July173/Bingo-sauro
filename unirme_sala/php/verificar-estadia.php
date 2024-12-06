<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    $id_usuario = $_SESSION['usuario_id'];

    // Obtener el código de partida desde la solicitud GET
    $codigoSala = isset($_GET['codigoPartida']) ? $_GET['codigoPartida'] : null;

    if (!$codigoSala) {
        throw new Exception('No se proporcionó el código de partida.');
    }

    // Verificar si el usuario está en la tabla usuario_partida_rol
    $query = "SELECT COUNT(*) as total FROM usuario_partida_rol WHERE id_usuario = ?";
    $result = $conexion->select($query, [$id_usuario]);

    if ($result && $result[0]['total'] > 0) {
        // Verificar el estado de la partida
        $query_estado = "SELECT estado FROM partida WHERE id_partida = (SELECT id_partida FROM partida WHERE codigo_sala = ? LIMIT 1)";
        $estado_result = $conexion->select($query_estado, [$codigoSala]);

        if ($estado_result && $estado_result[0]['estado'] === 'iniciada') {
            echo json_encode(['success' => true, 'message' => 'Usuario sigue en la partida.', 'redirect' => true]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Usuario sigue en la partida, pero la partida no está iniciada.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no está en la partida.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>
