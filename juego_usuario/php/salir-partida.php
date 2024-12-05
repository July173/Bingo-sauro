<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];

    // Obtener el código de la partida enviado por el JS
    $data = json_decode(file_get_contents("php://input"), true);
    $codigoPartida = isset($data['codigoPartida']) ? $data['codigoPartida'] : null;

    // Verificar que el código de la partida es válido
    if ($codigoPartida) {
        // Eliminar al usuario de la tabla usuario_partida_rol para el código de la partida
        $queryEliminar = "DELETE FROM usuario_partida_rol WHERE id_usuario = ? AND id_partida = (SELECT id_partida FROM partida WHERE codigo = ? LIMIT 1)";
        $conexion->delete($queryEliminar, [$id_usuario, $codigoPartida]);

        // Si la eliminación es exitosa, enviar mensaje y redirigir
        echo json_encode([
            'success' => true,
            'message' => 'Has salido de la partida.',
            'redirect' => true, // Indicamos que se debe redirigir
            'redirectUrl' => '../home/inicio.php' // URL a la que se redirige
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Código de partida inválido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>
