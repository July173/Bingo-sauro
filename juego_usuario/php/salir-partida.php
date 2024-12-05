<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        error_log("Error: Usuario no autenticado.");
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];
    error_log("ID del usuario autenticado: $id_usuario");

    // Obtener el código de la partida enviado por el JS
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Datos recibidos desde JS: " . json_encode($data));

    $codigoPartida = isset($data['codigoPartida']) ? $data['codigoPartida'] : null;
    error_log("Código de partida recibido: " . ($codigoPartida ?? 'No se recibió'));

    // Verificar que el código de la partida es válido
    if ($codigoPartida) {
        // Eliminar al usuario de la tabla usuario_partida_rol
        $queryEliminar = "DELETE FROM usuario_partida_rol WHERE id_usuario = ?";
        $conexion->delete($queryEliminar, [$id_usuario]);
        error_log("Consulta DELETE ejecutada con éxito para el usuario $id_usuario");

        // Si la eliminación es exitosa, enviar mensaje y redirigir
        echo json_encode([
            'success' => true,
            'message' => 'Has salido de la partida.',
            'redirect' => true, // Indicamos que se debe redirigir
            'redirectUrl' => '../home/inicio.php' // URL a la que se redirige
        ]);
        error_log("Respuesta enviada al cliente: Usuario eliminado y redirigido.");
    } else {
        error_log("Error: Código de partida inválido o no enviado.");
        echo json_encode(['success' => false, 'message' => 'Código de partida inválido.']);
    }
} catch (Exception $e) {
    error_log("Excepción capturada: " . $e->getMessage());
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
?>
