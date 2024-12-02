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

    // Consulta SQL para obtener el avatar del usuario
    $query = "
        SELECT a.id_articulo AS id, a.url AS src, a.nombre AS alt
        FROM articulo a
        JOIN usuario u ON u.id_avatar = a.id_articulo
        WHERE u.id_usuario = :id_usuario
    ";

    // Ejecutar la consulta con el ID del usuario
    $avatar = $conexion->select($query, ['id_usuario' => $id_usuario]);

    if ($avatar) {
        // Devolver los datos del avatar como un JSON
        echo json_encode(['avatar' => $avatar[0]]);
    } else {
        // Si no tiene avatar seleccionado
        echo json_encode(['error' => 'No se ha seleccionado un avatar']);
    }

} catch (Exception $e) {
    // Devolver error en caso de excepción
    echo json_encode(['error' => $e->getMessage()]);
}
