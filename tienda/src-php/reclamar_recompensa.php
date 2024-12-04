<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    $usuario_id = $_SESSION['usuario_id'];
    echo "Usuario ID: $usuario_id\n";

    echo "Contenido de \$_POST: ";
    print_r($_POST);

    $fecha = $_POST['fecha'] ?? null;
    echo "Fecha recibida: $fecha\n";

    if (!$fecha) {
        throw new Exception('Fecha no proporcionada');
    }

    // Lógica para reclamar la recompensa
    $query = "
        INSERT INTO historial_recompensa_diaria (id_usuario, fecha_recompensa, cantidad_monedas, estado)
        VALUES (?, ?, ?, 1)
        ON DUPLICATE KEY UPDATE cantidad_monedas = cantidad_monedas + VALUES(cantidad_monedas), estado = 1
    ";

    $params = [$usuario_id, $fecha, 10];
    echo "Consulta: $query\n";
    print_r($params);

    $result = $conexion->execute($query, $params);

    if ($result) {
        echo "Recompensa reclamada exitosamente.\n";
    } else {
        throw new Exception('Error al ejecutar la consulta');
    }

    // Segunda consulta para obtener monedas de recompensa_diaria
    $dia_semana = date('N', strtotime($fecha));
    $recompensa_query = "
        SELECT monedas_diarias 
        FROM recompensa_diaria 
        WHERE dia_semana = ?
    ";

    echo "Consulta de recompensa: $recompensa_query\n";
    print_r([$dia_semana]);

    $recompensa_result = $conexion->select($recompensa_query, [$dia_semana]);

    if (count($recompensa_result) > 0) {
        $monedas_recompensa = $recompensa_result[0]['monedas_diarias'];
        echo "Monedas de la segunda consulta: $monedas_recompensa\n";
    } else {
        echo "No se encontraron monedas para el día de la semana: $dia_semana\n";
        $monedas_recompensa = 0;
    }

    echo json_encode(['success' => true, 'monedas' => 10, 'monedas_recompensa' => $monedas_recompensa]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>