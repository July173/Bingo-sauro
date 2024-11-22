<?php
session_start();
require_once '../../conexion_BD/conexion.php';
header('Content-Type: application/json');

try {
    $conexion = new Conexion();
    
    // Establecer el id_categoria directamente como 1
    $id_categoria = 1;
    
    // Consulta filtrando por id_categoria
    $query = "SELECT id_articulo, nombre, url, precio, id_categoria, locked FROM articulo WHERE id_categoria = ?";
    $params = [$id_categoria];

    $result = $conexion->select($query, $params);

    // Verificar si hay resultados
    if (!empty($result)) {
        // Mostrar los resultados como JSON
        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    } else {
        // Enviar una respuesta indicando que no hay datos
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontraron avatares en esta categoría.'
        ]);
    }
} catch (Exception $e) {
    // Manejar errores
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
