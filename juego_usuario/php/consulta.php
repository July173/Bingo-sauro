<?php
require '../../conexion_BD/conexion.php';
session_start(); // Inicia la sesión para trabajar con $_SESSION

try {
    // Instancia de la conexión
    $conexion = new Conexion();
    $pdo = $conexion->getPdo();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION['usuario_id'];

    // Código de sala recibido
    $codigoSala = $_GET['codigo_sala'] ?? null;

    if (!$codigoSala) {
        throw new Exception('El código de sala es requerido');
    }

    // PASO 1: Obtener el id_partida usando el código de sala
    $queryPartida = "SELECT id_partida FROM partida WHERE codigo_sala = :codigo_sala";
    $paramsPartida = [':codigo_sala' => $codigoSala];
    $resultadoPartida = $conexion->select($queryPartida, $paramsPartida);

    if (empty($resultadoPartida)) {
        throw new Exception('No se encontró ninguna partida con el código proporcionado');
    }

    $id_partida = $resultadoPartida[0]['id_partida']; // Obtener el id_partida

    // PASO 2: Obtener monedas_apostar según id_usuario e id_partida
    $queryMonedas = "SELECT monedas_apostar FROM usuario_partida_rol WHERE id_usuario = :id_usuario AND id_partida = :id_partida";
    $paramsMonedas = [
        ':id_usuario' => $id_usuario,
        ':id_partida' => $id_partida
    ];
    $resultadoMonedas = $conexion->select($queryMonedas, $paramsMonedas);

    if (empty($resultadoMonedas)) {
        throw new Exception('No se encontró información de monedas para este usuario en esta partida');
    }

    $monedasApostar = $resultadoMonedas[0]['monedas_apostar']; // Obtener monedas_apostar

    // PASO 3: Obtener el id_usuario con id_rol = 2 para el mismo id_partida
    $queryOtroUsuario = "SELECT id_usuario FROM usuario_partida_rol WHERE id_partida = :id_partida AND id_rol = 2";
    $paramsOtroUsuario = [':id_partida' => $id_partida];
    $resultadoOtroUsuario = $conexion->select($queryOtroUsuario, $paramsOtroUsuario);

    if (empty($resultadoOtroUsuario)) {
        throw new Exception('No se encontró un usuario con el rol solicitado en esta partida');
    }

    $otroUsuarioId = $resultadoOtroUsuario[0]['id_usuario']; // Obtener el id_usuario del rol 2

    // PASO 4: Obtener el primer_nombre de ese usuario en la tabla usuario
    $queryNombre = "SELECT primer_nombre FROM usuario WHERE id_usuario = :id_usuario";
    $paramsNombre = [':id_usuario' => $otroUsuarioId];
    $resultadoNombre = $conexion->select($queryNombre, $paramsNombre);

    if (empty($resultadoNombre)) {
        throw new Exception('No se encontró información para el usuario con el rol 2');
    }

    $primerNombre = $resultadoNombre[0]['primer_nombre']; // Obtener primer_nombre

    // Respuesta final
    echo json_encode([
        'monedas_apostar' => $monedasApostar,
        'primer_nombre' => $primerNombre
    ]);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}
