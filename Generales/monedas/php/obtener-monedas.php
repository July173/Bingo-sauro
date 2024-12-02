<?php
require_once '../../../conexion_BD/conexion.php'; // Incluye el archivo de la clase Conexion

// Crear una instancia de la clase Conexion
try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar(); // Obtén el objeto PDO desde la clase Conexion
} catch (Exception $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die(json_encode(['exito' => false, 'mensaje' => 'Usuario no autenticado']));
}

$idUsuario = $_SESSION['usuario_id'];

try {
    $stmt = $pdo->prepare("SELECT contador_monedas FROM usuario WHERE id_usuario = ?");
    $stmt->execute([$idUsuario]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        echo json_encode(['exito' => true, 'monedas_restantes' => $usuario['contador_monedas']]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'No se pudo obtener el saldo de monedas.']);
    }
} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error al consultar las monedas: ' . $e->getMessage()]);
}
?>
