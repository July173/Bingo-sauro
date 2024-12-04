<?php
// unirse_partida.php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener datos del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];
    $nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';

    // Verificar que se envió el código de la partida
    if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
        throw new Exception('No se proporcionó el código de la partida');
    }

    $codigo = $_POST['codigo'];

    // Obtener el avatar del usuario desde la tabla usuario
    $queryAvatar = "SELECT id_avatar FROM usuario WHERE id_usuario = ?";
    $resultAvatar = $conexion->select($queryAvatar, [$id_usuario]);

    if (count($resultAvatar) === 0 || empty($resultAvatar[0]['id_avatar'])) {
        echo json_encode(['error' => 'Debes seleccionar un avatar antes de unirte a la partida.', 'success' => false]);
        exit;
    }

    $id_avatar = $resultAvatar[0]['id_avatar'];

    // Verificar que el código de la partida existe y obtener su estado
    $queryPartida = "SELECT id_partida, estado FROM partida WHERE codigo_sala = ?";
    $resultPartida = $conexion->select($queryPartida, [$codigo]);

    if (count($resultPartida) === 0) {
        echo json_encode(['error' => 'Código de partida no válido', 'success' => false]);
        exit;
    }

    $partida_id = $resultPartida[0]['id_partida'];
    $estado = $resultPartida[0]['estado'];

    // Validar el estado de la partida
    if ($estado === 'registrada') {
        // Insertar al jugador en la tabla usuario_partida_rol
        $id_rol = 1; // Suponiendo que este es el rol por defecto
        $queryJugador = "INSERT INTO usuario_partida_rol (id_usuario, id_partida, id_rol) VALUES (?, ?, ?)";
        $conexion->insert($queryJugador, [$id_usuario, $partida_id, $id_rol]);

        echo json_encode(['success' => true, 'nombre' => $nombre, 'foto' => $id_avatar]);
    } elseif ($estado === 'iniciada') {
        echo json_encode(['error' => 'La partida ya ha sido iniciada', 'success' => false]);
    } elseif ($estado === 'terminada') {
        echo json_encode(['error' => 'La partida ha finalizado', 'success' => false]);
    } else {
        echo json_encode(['error' => 'Estado de partida desconocido', 'success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
}
