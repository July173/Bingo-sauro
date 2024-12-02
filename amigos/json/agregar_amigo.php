<?php
require_once '../../conexion_BD/conexion.php';

session_start();
$usuario_id = $_SESSION['usuario_id'];
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que se haya recibido el JSON
if (is_null($data)) {
    echo json_encode(['success' => false, 'error' => 'No se recibió ningún dato.']);
    exit;
}

$amigo_id = $data['amigo_id']; // Asegúrate de que esto no sea nulo

// Verificar que amigo_id no sea nulo
if (is_null($amigo_id)) {
    echo json_encode(['success' => false, 'error' => 'amigo_id no puede ser nulo.']);
    exit;
}

$conexion = new Conexion();

// Verificar si el amigo ya está agregado
$query = "SELECT * FROM amigo WHERE usuario_id = :usuario_id AND amigo_id = :amigo_id";
$existe = $conexion->select($query, ['usuario_id' => $usuario_id, 'amigo_id' => $amigo_id]);

if (count($existe) > 0) {
    echo json_encode(['success' => false, 'error' => 'Este amigo ya está en tu lista.']);
    exit;
}

// Agregar el amigo a la base de datos
$query = "INSERT INTO amigo (usuario_id, amigo_id) VALUES (:usuario_id, :amigo_id)";
$conexion->insert($query, ['usuario_id' => $usuario_id, 'amigo_id' => $amigo_id]);

echo json_encode(['success' => true]);
?>
