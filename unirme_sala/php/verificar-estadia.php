<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    $id_usuario = $_SESSION['usuario_id'];
    $codigoSala = isset($_GET['codigoPartida']) ? $_GET['codigoPartida'] : null;
    error_log("EL CODIGO DE LA SALA EN EL SERVIDOR ES: ", $codigoSala);

    if (!$codigoSala) {
        throw new Exception('No se proporcionó el código de partida.');
    }

    $query = "
        SELECT COUNT(*) as total 
        FROM usuario_partida_rol upr
        JOIN partida p ON upr.id_partida = p.id_partida
        WHERE upr.id_usuario = ? AND p.codigo_sala = ?
    ";
    $result = $conexion->select($query, [$id_usuario, $codigoSala]);
    error_log ($codigoSala);

    if ($result && $result[0]['total'] > 0) {
        $query_estado = "SELECT estado FROM partida WHERE codigo_sala = ?";
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
    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>
