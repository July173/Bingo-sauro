<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $codigoPartida = $input['codigoPartida'] ?? null;

    if ($codigoPartida) {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare('DELETE FROM partida WHERE codigo_sala = :codigo');
        $stmt->bindParam(':codigo', $codigoPartida);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Código eliminado correctamente.']);
            
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el código.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Código no proporcionado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
