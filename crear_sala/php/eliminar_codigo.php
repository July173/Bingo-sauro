<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $codigoPartida = $input['codigoPartida'] ?? null;

    if ($codigoPartida) {
        // Crear instancia de conexión
        $conexion = new Conexion();

        // Iniciar una transacción
        $pdo = $conexion->conectar();
        $pdo->beginTransaction();

        // Obtener el ID de la partida a partir del código
        $queryPartida = "SELECT id_partida FROM partida WHERE codigo_sala = :codigo";
        $params = [':codigo' => $codigoPartida];
        $resultado = $conexion->select($queryPartida, $params);

        if (empty($resultado)) {
            echo json_encode(['success' => false, 'message' => 'Código de partida no encontrado.']);
            $pdo->rollBack(); // Revertir cambios si no existe la partida
            exit();
        }

        $idPartida = $resultado[0]['id_partida'];

        // Eliminar los usuarios asociados en la tabla usuario_partida_rol
        $queryEliminarRoles = "DELETE FROM usuario_partida_rol WHERE id_partida = :id_partida";
        $conexion->delete($queryEliminarRoles, [':id_partida' => $idPartida]);

        // Eliminar la partida en la tabla partida
        $queryEliminarPartida = "DELETE FROM partida WHERE id_partida = :id_partida";
        $conexion->delete($queryEliminarPartida, [':id_partida' => $idPartida]);

        // Confirmar la transacción
        $pdo->commit();

        // Respuesta de éxito
        echo json_encode(['success' => true, 'message' => 'Partida eliminada correctamente, junto con los usuarios.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Código de partida no proporcionado.']);
    }
} catch (PDOException $e) {
    if (isset($pdo)) {
        $pdo->rollBack(); // Revertir cambios en caso de error
    }
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
