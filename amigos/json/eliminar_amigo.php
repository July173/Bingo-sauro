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

// Obtener el ID del amigo a eliminar
$data = json_decode(file_get_contents("php://input"), true);
$amigo_id = $data['amigo_id'];

// Eliminar el amigo de la base de datos
$query = "DELETE FROM amigo WHERE usuario_id = :usuario_id AND amigo_id = :amigo_id";
$result = $conexion->insert($query, ['usuario_id' => $usuario_id, 'amigo_id' => $amigo_id]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el amigo.']);
}
?> 