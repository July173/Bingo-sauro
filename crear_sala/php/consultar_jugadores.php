<?php
header('Content-Type: application/json');
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el código de la partida está en la sesión
    if (!isset($_SESSION['codigo_partida'])) {
        throw new Exception('Código de partida no encontrado en la sesión');
    }

    $codigo_partida = $_SESSION['codigo_partida'];

    // Obtener el ID de la partida con el código
    $queryPartida = "SELECT id_partida FROM partida WHERE codigo_sala = ?";
    $resultPartida = $conexion->select($queryPartida, [$codigo_partida]);

    if (count($resultPartida) === 0) {
        throw new Exception('Código de partida no válido');
    }

    $id_partida = $resultPartida[0]['id_partida'];

   // Consultar jugadores con rol 1
    $queryJugadores = "
    SELECT 
        u.primer_nombre AS nombre,
        a.url AS avatar
    FROM usuario_partida_rol upr
    INNER JOIN usuario u ON upr.id_usuario = u.id_usuario
    INNER JOIN articulo a ON u.id_avatar = a.id_articulo
    WHERE upr.id_partida = ? AND upr.id_rol = 1
    ";
    $jugadores = $conexion->select($queryJugadores, [$id_partida]);

    echo json_encode([
        'success' => true,
        'jugadores' => $jugadores
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
