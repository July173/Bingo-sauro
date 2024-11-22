<?php
session_start();
require_once '../../conexion_BD/conexion.php';
header('Content-Type: application/json');

try {
    $conexion = new Conexion();

    // Validar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado.']);
        exit;
    }

    $user_id = $_SESSION['usuario_id']; // ID del usuario autenticado

    // Detectar la acción según un parámetro enviado en la solicitud
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    if ($action === 'getAvatars') {
        // Obtener todos los avatares de una categoría específica (por ejemplo, id_categoria = 1)
        $id_categoria = 1;
        $query = "SELECT id_articulo, nombre, url, precio, id_categoria, locked FROM articulo WHERE id_categoria = ?";
        $result = $conexion->select($query, [$id_categoria]);

        if (!empty($result)) {
            echo json_encode(['status' => 'success', 'data' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron avatares en esta categoría.']);
        }
    } elseif ($action === 'getSelectedAvatar') {
        // Obtener el avatar seleccionado del usuario actual
        $query = "SELECT id_avatar FROM usuario WHERE id_usuario = ?";
        $result = $conexion->select($query, [$user_id]);

        if (!empty($result)) {
            echo json_encode(['status' => 'success', 'id_avatar' => $result[0]['id_avatar']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró el avatar del usuario.']);
        }
    } elseif ($action === 'updateAvatar') {
        // Actualizar el avatar seleccionado del usuario actual
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id_avatar'])) {
            echo json_encode(['status' => 'error', 'message' => 'Falta id_avatar.']);
            exit;
        }

        $id_avatar = $input['id_avatar'];
        $query = "UPDATE usuario SET id_avatar = ? WHERE id_usuario = ?";
        $result = $conexion->update($query, [$id_avatar, $user_id]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Avatar actualizado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el avatar.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
