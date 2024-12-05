<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    $usuario_id = $_SESSION['usuario_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Leer el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);

        // Obtener la fecha y cantidadMonedas desde el JSON recibido
        $fecha = $data['fecha'] ?? null;
        $cantidadMonedas = $data['cantidadMonedas'] ?? null;

        if (!$fecha || !$cantidadMonedas) { // Asegúrate de que cantidadMonedas también esté presente
            throw new Exception('Fecha o monedas no proporcionada');
        }

        // Insertar recompensa diaria en el historial
        $query = "
            INSERT INTO historial_recompensa_diaria (id_usuario, fecha_recompensa, cantidad_monedas)
            VALUES (?, ?, ?)
        ";
        $params = [$usuario_id, $fecha, $cantidadMonedas];
        $ultimo_id_insertado = $conexion->insert($query, $params);

        if (!$ultimo_id_insertado) {
            throw new Exception('Error al ejecutar la consulta para reclamar recompensa');
        }

        // Consultar el contador de monedas del usuario
        $query_usuario = "
            SELECT contador_monedas 
            FROM usuario 
            WHERE id_usuario = ?
        ";
        $usuario_result = $conexion->select($query_usuario, [$usuario_id]);

        if (empty($usuario_result)) {
            throw new Exception('Usuario no encontrado');
        }

        // Sumar la cantidad de monedas
        $contador_monedas_actual = $usuario_result[0]['contador_monedas'] ?? 0;
        $nuevo_contador_monedas = $contador_monedas_actual + $cantidadMonedas;

        // Actualizar el contador de monedas del usuario
        $query_update = "
            UPDATE usuario 
            SET contador_monedas = ?
            WHERE id_usuario = ?
        ";
        $params_update = [$nuevo_contador_monedas, $usuario_id];
        $conexion->update($query_update, $params_update);

        echo json_encode(['success' => true, 'monedas' => $cantidadMonedas]);
    } else {
        throw new Exception('Método HTTP no soportado');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
