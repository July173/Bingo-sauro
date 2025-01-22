<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

try {
    // Crear instancia de la clase Conexion
    $conexion = new Conexion();

    // Obtener los datos enviados como JSON
    $data = file_get_contents('php://input');
    error_log("Datos recibidos crudos: " . $data);

    // Decodificar los datos JSON
    $dataDecoded = json_decode($data, true);

    // Verificar si la decodificación fue exitosa
    if ($dataDecoded === null) {
        echo json_encode(['success' => false, 'message' => 'Datos JSON inválidos']);
        error_log("Error al decodificar JSON: " . json_last_error_msg());
        exit;
    }

    // Verificar si el código fue proporcionado
    $codigoSala = $dataDecoded['codigo'] ?? null;
    error_log("Código de sala: " . json_encode($codigoSala));

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

    // Consultar una bola aleatoria que no haya salido en esta partida
    $queryBola = "
        SELECT b.id_bola, b.letra, b.numero, b.url 
        FROM bolas_bingo b
        WHERE b.id_bola NOT IN (
            SELECT id_bola 
            FROM historial_llamadas 
            WHERE id_partida = ?
        )
        ORDER BY RAND()
        LIMIT 1
    ";
    $resultadoBola = $conexion->select($queryBola, [$idPartida]);

    if (empty($resultadoBola)) {
        echo json_encode(['success' => false, 'message' => 'No hay más bolas disponibles para esta partida']);
        exit;
    }

    $bola = $resultadoBola[0];
    $idBola = $bola['id_bola'];
    $letra = $bola['letra'];
    $numero = $bola['numero'];
    $imagen = $bola['url'];

    // Insertar los datos en historial_llamadas
    $queryHistorial = "INSERT INTO historial_llamadas (id_partida, id_bola, letra, numero_llamada) VALUES (?, ?, ?, ?)";
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
            'numero_llamada' => $numero,
            'url' => $imagen
        ]
    ]);
} catch (Exception $e) {
    // Respuesta en caso de error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
