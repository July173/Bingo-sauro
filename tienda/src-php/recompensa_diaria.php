<?php
session_start();
require '../../conexion_BD/conexion.php';

try {
    $conexion = new Conexion();

    // Aquí puedes definir la lógica para obtener las recompensas diarias
    // Por ejemplo, puedes devolver un JSON con las monedas diarias por día de la semana

    $query = "SELECT dia_semana, monedas_diarias FROM recompensa_diaria";
    $result = $conexion->select($query);

    echo json_encode(['success' => true, 'recompensas' => $result]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?> 