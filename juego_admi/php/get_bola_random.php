<?php
require '../../conexion_BD/conexion.php';

try {
    // Instancia de la conexión
    $conexion = new Conexion();
    $pdo = $conexion->getPdo();

    // Consulta una imagen aleatoria
    $query = "SELECT * FROM bolas_bingo ORDER BY RAND() LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna la imagen como JSON
    if ($image && isset($image['url'])) {
        echo json_encode($image); // Retorna la URL como JSON
    } else {
        echo json_encode(['error' => 'No se encontró una bola']);
    }
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}
?>
