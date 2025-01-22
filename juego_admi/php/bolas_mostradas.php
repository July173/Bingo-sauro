<?php


header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

try {
    // Crear instancia de la clase Conexion
    $conexion = new Conexion();

    // Obtener los datos enviados como JSON
    $data = file_get_contents('php://input');
    $dataDecoded = json_decode($data, true);

    if ($dataDecoded === null) {
        echo json_encode(['success' => false, 'message' => 'Datos JSON inválidos']);
        exit;
    }

    // Verificar si el código de sala fue proporcionado
    $codigoSala = $dataDecoded['codigo'] ?? null;
    if (!$codigoSala) {
        echo json_encode(['success' => false, 'message' => 'Código de sala no proporcionado']);
        exit;
    }

    // Obtener el id_partida basado en el código de sala
    $queryPartida = "SELECT id_partida FROM partida WHERE codigo_sala = ?";
    $resultadoPartida = $conexion->select($queryPartida, [$codigoSala]);

    if (empty($resultadoPartida)) {
        echo json_encode(['success' => false, 'message' => 'Código de sala no encontrado']);
        exit;
    }

    $idPartida = $resultadoPartida[0]['id_partida'];

    // Consultar todas las bolas llamadas para esta partida
    $queryBolas = "
        SELECT h.letra, h.numero_llamada, b.url 
        FROM historial_llamadas h
        JOIN bolas_bingo b ON h.id_bola = b.id_bola
        WHERE h.id_partida = ?
    ";
    $resultadoBolas = $conexion->select($queryBolas, [$idPartida]);

    if (empty($resultadoBolas)) {
        echo json_encode(['success' => false, 'message' => 'No hay bolas registradas para esta partida']);
        exit;
    }

    // Devolver las bolas llamadas
    echo json_encode([
        'success' => true,
        'message' => 'Bolas llamadas obtenidas correctamente',
        'data' => $resultadoBolas
    ]);
} catch (Exception $e) {
    // Manejar errores
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>