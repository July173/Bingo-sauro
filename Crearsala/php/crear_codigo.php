<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

// Instanciar conexión
$conexion = new Conexion();
$pdo = $conexion->conectar();

// Validar conexión
if (!$pdo) {
    echo json_encode(['error' => 'Error al conectar con la base de datos', 'success' => false]);
    exit();
}

// Función para generar un código aleatorio de 6 caracteres
function generarCodigo($longitud = 6): string
{
    return substr(str_shuffle("0123456789"), 0, $longitud);
}

try {
    $resultado = 0;
    do {
        $codigo = generarCodigo();
        $codigoConsultado = $pdo->prepare("SELECT COUNT(*) as total FROM partida WHERE codigo_sala = :codigo");
        $codigoConsultado->bindParam(':codigo', $codigo);
        $codigoConsultado->execute();
        $resultado = $codigoConsultado->fetchColumn();
    } while ($resultado > 0);

    // Insertar nuevo código en la base de datos
    $stmt = $pdo->prepare("INSERT INTO partida (codigo_sala, monedas_minimas, maximo_cartones) VALUES (:codigo, 0, 0)");
    $stmt->bindParam(':codigo', $codigo);

    if ($stmt->execute()) {
        echo json_encode(['codigo_sala' => $codigo, 'success' => true]);
    } else {
        echo json_encode(['error' => 'Error al generar el código', 'success' => false]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage(), 'success' => false]);
}
