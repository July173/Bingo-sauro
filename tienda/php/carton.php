<?php
session_start();
header('Content-Type: application/json');

// Incluir archivo de conexión
require '../../conexion_BD/conexion.php';

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION['usuario_id'];

    // Instanciar la clase Conexion
    $conexion = new Conexion();

    // Consulta SQL para obtener los cartones
    $query = "
        SELECT 
            a.id_articulo AS id,
            a.url AS src,
            a.nombre AS alt,
            a.precio AS price,
            CASE 
                WHEN ua.id_usuario IS NULL THEN true
                ELSE false
            END AS locked
        FROM 
            articulo a
        LEFT JOIN 
            usuario_articulo ua ON a.id_articulo = ua.id_articulo AND ua.id_usuario = :id_usuario
        WHERE 
            a.id_categoria = 3;
    ";

    // Ejecutar la consulta con el ID del usuario
    $cartones = $conexion->select($query, ['id_usuario' => $id_usuario]);

    // Devolver los cartones como un JSON
    echo json_encode(['cartones' => $cartones]);

} catch (Exception $e) {
    // Devolver error en caso de excepción
    echo json_encode(['error' => $e->getMessage()]);
}