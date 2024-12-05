<?php
require '../../conexion_BD/conexion.php';

try {
    // Instancia de la conexión
    $conexion = new Conexion();
    $pdo = $conexion->getPdo();

    // Código de sala recibido, por ejemplo desde una solicitud GET o POST
    $codigoSala = $_GET['codigo_sala'] ?? null; // Usa GET o POST según sea el caso

    if (!$codigoSala) {
        throw new Exception('El código de sala es requerido');
    }

    // Consulta a la tabla partida
    $query = "SELECT monedas_minimas, maximo_cartones FROM partida WHERE codigo_sala = :codigo_sala";
    $params = [':codigo_sala' => $codigoSala];
    $resultado = $conexion->select($query, $params);

    if (empty($resultado)) {
        echo json_encode(['error' => 'No se encontró ninguna partida con el código proporcionado']);
    } else {
        echo json_encode($resultado[0]); // Devuelve solo el primer resultado
    }
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}
