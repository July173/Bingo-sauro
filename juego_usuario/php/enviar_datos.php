<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        error_log("Error: Usuario no autenticado.");
        throw new Exception('Usuario no autenticado.');
    }

    // Obtener el ID del usuario desde la sesión
    $id_usuario = $_SESSION['usuario_id'];
    error_log("ID del usuario autenticado: $id_usuario");

    // Obtener los datos enviados desde el cliente
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Datos recibidos desde el cliente: " . json_encode($data));

    // Verificar que se recibieron los datos necesarios
    $monedas = isset($data['monedas']) ? (int)$data['monedas'] : null;
    $cartones = isset($data['cartones']) ? (int)$data['cartones'] : null;
    $codigo_partida = isset($data['codigo']) ? $data['codigo'] : null;
    error_log($codigo_partida);

    if ($monedas === null || $cartones === null || $codigo_partida === null) {
        throw new Exception('Faltan datos para procesar.');
    }

    // Obtener las monedas actuales del usuario desde la tabla usuario
    $consultaMonedas = "SELECT contador_monedas FROM usuario WHERE id_usuario = ?";
    $resultado = $conexion->select($consultaMonedas, [$id_usuario]);

    if (empty($resultado)) {
        throw new Exception('No se encontró al usuario.');
    }

    $monedas_actuales = (int)$resultado[0]['contador_monedas'];

    // Obtener las monedas mínimas y los cartones máximos desde la tabla partida usando el código de partida
    $consultaPartida = "SELECT monedas_minimas, maximo_cartones FROM partida WHERE codigo_sala = ?";
    $resultadoPartida = $conexion->select($consultaPartida, [$codigo_partida]);

    if (empty($resultadoPartida)) {
        throw new Exception('No se encontró la partida.');
    }

    $monedas_minimas = (int)$resultadoPartida[0]['monedas_minimas'];
    $maximo_cartones = (int)$resultadoPartida[0]['maximo_cartones'];

    // Verificar que el monto de monedas sea suficiente y cumpla con el mínimo
    if ($monedas < $monedas_minimas) {
        throw new Exception("La cantidad mínima de monedas para apostar es $monedas_minimas.");
    }

    // Verificar que el número de cartones no exceda el máximo permitido
    if ($cartones > $maximo_cartones) {
        throw new Exception("El número máximo de cartones es $maximo_cartones.");
    }

    // Verificar si el usuario tiene suficientes monedas
    if ($monedas_actuales < $monedas) {
        throw new Exception('No tienes suficientes monedas para apostar.');
    }

    // Calcular las monedas restantes
    $monedas_restantes = $monedas_actuales - $monedas;

    // Iniciar transacción manual
    $conexion->getPdo()->beginTransaction();

    // Actualizar las monedas y los cartones en la tabla usuario_partida_rol
    $queryPartidaRol = "UPDATE usuario_partida_rol 
                        SET monedas_apostar = ?, numero_cartones = ? 
                        WHERE id_usuario = ? AND id_partida = (SELECT id_partida FROM partida WHERE codigo_sala=?)";
    $conexion->update($queryPartidaRol, [$monedas, $cartones, $id_usuario, $codigo_partida]);

    // Actualizar el contador de monedas en la tabla usuario
    $queryUsuario = "UPDATE usuario SET contador_monedas = ? WHERE id_usuario = ?";
    $conexion->update($queryUsuario, [$monedas_restantes, $id_usuario]);

    // Confirmar los cambios
    $conexion->getPdo()->commit();

    error_log("Actualización realizada con éxito: monedas_apostar = $monedas, numero_cartones = $cartones, contador_monedas = $monedas_restantes");

    // Enviar respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Datos actualizados correctamente.',
        'monedas' => $monedas_minimas,
        'cartones' => $maximo_cartones
    ]);
} catch (Exception $e) {
    // Revertir los cambios si hubo un error
    if ($conexion->getPdo()->inTransaction()) {
        $conexion->getPdo()->rollBack();
    }

    error_log("Excepción capturada: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
