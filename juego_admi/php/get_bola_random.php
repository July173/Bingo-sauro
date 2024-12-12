<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

try {
    // Crear instancia de la clase Conexion
    $conexion = new Conexion();

    // Obtener el código de sala desde el POST
    $codigoSala = $_POST['codigo'] ?? null;

    if (!$codigoSala) {
        echo json_encode(['success' => false, 'message' => 'Código de sala no proporcionado']);
        exit;
    }

    // Obtener id_partida a partir del codigo_sala
    $queryPartida = "SELECT id_partida FROM partida WHERE codigo_sala = ?";
    $resultadoPartida = $conexion->select($queryPartida, [$codigoSala]);

    if (empty($resultadoPartida)) {
        echo json_encode(['success' => false, 'message' => 'Código de sala no encontrado']);
        exit;
    }

    $idPartida = $resultadoPartida[0]['id_partida'];

    // Consultar una imagen aleatoria de bolas_bingo
    $queryBola = "SELECT id_bola, letra, numero, url FROM bolas_bingo ORDER BY RAND() LIMIT 1";
    $resultadoBola = $conexion->select($queryBola);

    if (empty($resultadoBola)) {
        echo json_encode(['success' => false, 'message' => 'No hay bolas disponibles']);
        exit;
    }

    $bola = $resultadoBola[0];
    $idBola = $bola['id_bola'];
    $letra = $bola['letra'];
    $numero = $bola['numero'];
    $imagen = $bola['url'];

    // Insertar los datos en historial_llamadas
    $queryHistorial = "INSERT INTO historial_llamadas (id_partida, id_bola, letra, numero) VALUES (?, ?, ?, ?)";
    $paramsHistorial = [$idPartida, $idBola, $letra, $numero];

    $conexion->insert($queryHistorial, $paramsHistorial);

    // Respuesta en caso de éxito
    echo json_encode([
        'success' => true,
        'message' => 'Imagen obtenida y datos guardados en historial_llamadas',
        'data' => [
            'id_partida' => $idPartida,
            'id_bola' => $idBola,
            'letra' => $letra,
            'numero' => $numero,
            'url' => $imagen
        ]
    ]);
} catch (Exception $e) {
    // Respuesta en caso de error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
