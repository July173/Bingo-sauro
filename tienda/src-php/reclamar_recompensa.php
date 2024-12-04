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
        // Reclamar recompensa diaria
        $fecha = $_POST['fecha'] ?? null;

        if (!$fecha) {
            throw new Exception('Fecha no proporcionada');
        }

        // Insertar o actualizar la recompensa diaria en el historial
        $query = "
            INSERT INTO historial_recompensa_diaria (id_usuario, fecha_recompensa, cantidad_monedas, estado)
            VALUES (?, ?, ?, 1)
            ON DUPLICATE KEY UPDATE cantidad_monedas = cantidad_monedas + VALUES(cantidad_monedas), estado = 1
        ";
        $params = [$usuario_id, $fecha, 10];
        $result = $conexion->execute($query, $params);

        if (!$result) {
            throw new Exception('Error al ejecutar la consulta para reclamar recompensa');
        }

        // Obtener monedas de la tabla recompensa_diaria
        $dia_semana = date('N', strtotime($fecha));
        $recompensa_query = "
            SELECT monedas_diarias 
            FROM recompensa_diaria 
            WHERE dia_semana = ?
        ";
        $recompensa_result = $conexion->select($recompensa_query, [$dia_semana]);

        $monedas_recompensa = $recompensa_result[0]['monedas_diarias'] ?? 0;

        echo json_encode(['success' => true, 'monedas' => 10, 'monedas_recompensa' => $monedas_recompensa]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Obtener el estado de los cofres para ayer, hoy y mañana
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
                $dia_semana = date('N', strtotime($dia));
                $recompensa_query = "
                    SELECT monedas_diarias 
                    FROM recompensa_diaria 
                    WHERE id_recompensa = ?
                ";
                $recompensa_result = $conexion->select($recompensa_query, [$dia_semana]);
                $monedas = $recompensa_result[0]['monedas_diarias'] ?? 0;
            }

            // Modificar el array de estados para incluir el estado del cofre
            $estados[] = [
                'fecha' => $dia,
                'monedas' => $monedas,
                'encontrado' => $encontrado,
                'estado' => !$encontrado ? ($dia === $dias[1] ? 'disponible' : ($dia === $dias[2] ? 'mañana' : 'pasado')) : 'reclamado'
            ];
        }

        echo json_encode(['success' => true, 'dias' => $estados]);
    } else {
        throw new Exception('Método HTTP no soportado');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
