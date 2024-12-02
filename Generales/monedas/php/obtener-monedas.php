<?php
require_once '../../../conexion_BD/conexion.php'; // Incluye el archivo de la clase Conexion

// Iniciar sesión para verificar la autenticación
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'Usuario no autenticado']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

try {
    // Crear una instancia de la clase Conexion
    $conexion = new Conexion();
    $pdo = $conexion->conectar(); // Establece la conexión con la base de datos

    // Preparar la consulta para obtener las monedas del usuario
    $query = "SELECT contador_monedas FROM usuario WHERE id_usuario = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idUsuario]);

    $usuario = $stmt->fetch();

    if ($usuario) {
        // Devolver las monedas restantes si se encontró el usuario
        echo json_encode(['exito' => true, 'monedas_restantes' => $usuario['contador_monedas']]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'No se pudo obtener el saldo de monedas.']);
    }
} catch (Exception $e) {
    // Manejar cualquier excepción y devolver un mensaje de error
    echo json_encode(['exito' => false, 'mensaje' => 'Error al consultar las monedas: ' . $e->getMessage()]);
    exit;
}
