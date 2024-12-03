<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No estás autenticado.']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conectar a la base de datos
require_once '../../conexion_BD/conexion.php';
$conexion = new Conexion();

// Obtener el ID del amigo a verificar
$data = json_decode(file_get_contents("php://input"), true);
$amigo_id = $data['amigo_id'];

// Verificar si el amigo existe en la base de datos
$query = "SELECT COUNT(*) as count FROM usuario WHERE id_usuario = :amigo_id";
$result = $conexion->select($query, ['amigo_id' => $amigo_id]);

if ($result && isset($result[0]['count'])) {
    if ($result[0]['count'] > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'Error en la consulta.']);
}
?> 