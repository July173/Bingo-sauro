<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php'; // Archivo con la conexión a la BD

if (!isset($pdo)) {
    die(json_encode(['error' => 'Error: No se pudo establecer la conexión a la base de datos']));
}

// Función para generar un código aleatorio de 6 caracteres
function generarCodigo($longitud = 6): string
{
    return substr(str_shuffle("0123456789"), 0, $longitud);
}

$codigo = generarCodigo();
try {


    $resultado = 0;
    while ($resultado > 0) {
        // Verificar si se encontraron resultados


        $codigo = generarCodigo();
        $codigoConsultado = $pdo->prepare("SELECT codigo_sala  FROM partida where codigo_sala= :codigo");
        $codigoConsultado->bindParam(':codigo', $codigo);
        // Ejecutar la consulta
        $codigoConsultado->execute();


        // Si rowCount es mayor a 0, existe una partida con ese código
        echo json_encode(['exists' => true, 'message' => 'El código de partida ya existe.']);

        $resultado = $codigoConsultado->fetch(PDO::FETCH_ASSOC);
    }


    $stmt = $pdo->prepare("INSERT INTO partida (codigo_sala,monedas_minimas, maximo_cartones) VALUES (:codigo,0,0)");
    $stmt->bindParam(':codigo', $codigo);
   

    // Preparar la consulta SQL para insertar el código en la base de datos

    if ($stmt->execute()) {
        echo json_encode(['codigo_sala' => $codigo, 'success' => true]);
    } else {
        echo json_encode(['error' => 'Error al generar el código', 'success' => false]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage(), 'success' => false]);
}
