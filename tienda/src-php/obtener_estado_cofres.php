<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    $usuario_id = $_SESSION['usuario_id'];

    // Obtener la fecha de ayer, hoy y mañana
    $hoy = new DateTime();
    $dias = [
        $hoy->modify('-1 day')->format('Y-m-d'), // Ayer
        (new DateTime())->format('Y-m-d'), // Hoy
        $hoy->modify('+2 day')->format('Y-m-d') // Mañana
    ];

    // Consulta para verificar el estado de cada día
    $placeholders = implode(',', array_fill(0, count($dias), '?'));
    $query = "
        SELECT 
            DATE(h.fecha_recompensa) as fecha,
            h.cantidad_monedas as monedas
        FROM historial_recompensa_diaria h
        WHERE h.id_usuario = ? AND DATE(h.fecha_recompensa) IN ($placeholders)
    ";

    $params = array_merge([$usuario_id], $dias);
    $result = $conexion->select($query, $params);

    // Procesar resultados
    $estados = [];
    foreach ($dias as $dia) {
        $encontrado = false;
        $monedas = 0;
        foreach ($result as $fila) {
            if ($fila['fecha'] === $dia) {
                $monedas = $fila['monedas'];
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            // Si no se encontró en historial_recompensa_diaria, consultar recompensa_diaria
            $dia_semana = date('N', strtotime($dia)); // Obtiene el día de la semana (1=lunes, 7=domingo)
            $recompensa_query = "
                SELECT monedas_diarias 
                FROM recompensa_diaria 
                WHERE id_recompensa = ?
            ";
            $recompensa_result = $conexion->select($recompensa_query, [$dia_semana]);
            
            if (count($recompensa_result) > 0) {
                $monedas = $recompensa_result[0]['monedas_diarias'];

            }
            
        }

        $estados[] = [
            'fecha' => $dia,
            'monedas' => $monedas,
            'encontrado' => $encontrado  // Campo que indica si se encontró en historial_recompensa_diaria
        ];
    }

    echo json_encode(['success' => true, 'dias' => $estados]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>