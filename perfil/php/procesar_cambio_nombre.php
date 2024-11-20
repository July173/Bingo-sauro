<?php
session_start();
require_once '../../conexion_BD/conexion.php';

header('Content-Type: application/json');

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Validar que los campos no estén vacíos
    if (empty($_POST['nuevo_nombre']) || empty($_POST['confirmar_nombre'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    // Validar que los nombres coincidan
    if ($_POST['nuevo_nombre'] !== $_POST['confirmar_nombre']) {
        throw new Exception('Los nombres no coinciden');
    }

    $nuevo_nombre = trim($_POST['nuevo_nombre']);

    // Validar longitud mínima
    if (strlen($nuevo_nombre) < 5) {
        throw new Exception('El nombre debe tener al menos 5 caracteres');
    }

    // Actualizar en la base de datos
    $conexion = new Conexion();
    $query = "UPDATE usuario SET primer_nombre = :nuevo_nombre WHERE id_usuario = :usuario_id";
    $params = [
        ':nuevo_nombre' => $nuevo_nombre,
        ':usuario_id' => $_SESSION['usuario_id']
    ];

    if ($conexion->update($query, $params)) {
        // Actualizar el nombre en la sesión
        $_SESSION['nombre'] = $nuevo_nombre;
        
        echo json_encode([
            'success' => true,
            'mensaje' => 'Nombre actualizado correctamente'
        ]);
    } else {
        throw new Exception('Error al actualizar el nombre');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => $e->getMessage()
    ]);
}
?> 