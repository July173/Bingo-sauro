<?php
session_start();
include '../../conexion_BD/conexion.php'; // Verifica que esta ruta sea correcta

if (!isset($_SESSION['id_usuario'])) {
    die('Usuario no autenticado.');
}

$usuario_id = $_SESSION['id_usuario'];  
$fecha_hoy = date('Y-m-d');

// Crear una instancia de la conexión
$conexion = new Conexion();

// Verificar si el usuario ya recibió la recompensa hoy
$query = "SELECT * FROM historial_recompensa_diaria WHERE id_usuario = :usuario_id AND fecha_recompensa = :fecha";
$params = [
    ':usuario_id' => $usuario_id,
    ':fecha' => $fecha_hoy
];
$resultado = $conexion->select($query, $params);

if (empty($resultado)) {
    // Si no hay registro, otorgar la recompensa
    $dia_semana = date('N'); // Obtener el día de la semana (1 = lunes, 7 = domingo)
    $query_recompensa = "SELECT * FROM recompensa_diaria WHERE dia_semana = :dia_semana";
    $params_recompensa = [':dia_semana' => $dia_semana];
    $recompensa = $conexion->select($query_recompensa, $params_recompensa);

    if (!empty($recompensa)) {
        // Insertar en el historial de recompensas
        $query_insert = "INSERT INTO historial_recompensa_diaria (id_usuario, id_recompensa, fecha_recompensa, cantidad_monedas) VALUES (:usuario_id, :recompensa_id, :fecha, :cantidad)";
        $params_insert = [
            ':usuario_id' => $usuario_id,
            ':recompensa_id' => $recompensa[0]['id_recompensa'], // Asumiendo que solo hay una recompensa por día
            ':fecha' => $fecha_hoy,
            ':cantidad' => $recompensa[0]['monedas_diarias']
        ];
        $conexion->insert($query_insert, $params_insert);

        // Aquí puedes agregar la lógica para otorgar las monedas al usuario
        // Por ejemplo, actualizar el contador de monedas del usuario
        $query_update = "UPDATE usuario SET contador_monedas = contador_monedas + :cantidad WHERE id_usuario = :usuario_id";
        $params_update = [
            ':cantidad' => $recompensa[0]['monedas_diarias'],
            ':usuario_id' => $usuario_id
        ];
        $conexion->update($query_update, $params_update);

        echo json_encode(['mensaje' => 'Recompensa otorgada', 'cantidad' => $recompensa[0]['monedas_diarias']]);
    } else {
        echo json_encode(['mensaje' => 'No hay recompensas disponibles para hoy.']);
    }
} else {
    echo json_encode(['mensaje' => 'Ya has recibido tu recompensa hoy.']);
}
?> 