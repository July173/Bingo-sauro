<?php
// Incluir la clase de conexión
  // Iniciar sesión para obtener el ID del usuario
  session_start();
require '../../conexion_BD/conexion.php';

// Leer los datos enviados desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_carton'])) {
    $id_carton = intval($data['id_carton']);

  
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION['usuario_id'];

    try {
        // Crear una instancia de la clase de conexión
        $conexion = new Conexion();

        // Actualizar la columna `id_color_carton` en la tabla `usuario`
        $query = "UPDATE usuario SET id_color_carton = :id_carton WHERE id_usuario = :id_usuario";
        $params = [
            ':id_carton' => $id_carton,
            ':id_usuario' => $id_usuario,
        ];

        // Ejecutar la consulta
        $resultado = $conexion->execute($query, $params);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el cartón.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID de cartón no recibido.']);
}
?>
