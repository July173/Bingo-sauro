<?php
session_start();
require '../../conexion_BD/conexion.php';

header('Content-Type: application/json'); // Asegura que siempre se devuelva JSON

try {
    $conexion = new Conexion();

    // Verifica que el usuario esté autenticado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Usuario no autenticado.');
    }
    $id_usuario = $_SESSION['usuario_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Procesar solicitud GET (obtener restricciones de la partida)
        $codigo_partida = isset($_GET['codigo']) ? $_GET['codigo'] : null;

        if (!$codigo_partida) {
            throw new Exception('Código de partida no especificado.');
        }

        // Obtener monedas mínimas y máximo de cartones desde la tabla partida
        $consultaPartida = "SELECT monedas_minimas, maximo_cartones FROM partida WHERE codigo_sala = ?";
        $resultadoPartida = $conexion->select($consultaPartida, [$codigo_partida]);

        if (empty($resultadoPartida)) {
            throw new Exception('No se encontró la partida.');
        }

        echo json_encode([
            'success' => true,
            'monedas_minimas' => (int)$resultadoPartida[0]['monedas_minimas'],
            'maximo_cartones' => (int)$resultadoPartida[0]['maximo_cartones'],
        ]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar solicitud POST (enviar datos)
        $data = json_decode(file_get_contents("php://input"), true);

        $monedas = isset($data['monedas']) ? (int)$data['monedas'] : null;
        $cartones = isset($data['cartones']) ? (int)$data['cartones'] : null;
        $codigo_partida = isset($data['codigo']) ? $data['codigo'] : null;

        if ($monedas === null || $cartones === null || $codigo_partida === null) {
            throw new Exception('Faltan datos para procesar.');
        }

        // Obtener monedas actuales del usuario
        $consultaMonedas = "SELECT contador_monedas FROM usuario WHERE id_usuario = ?";
        $resultado = $conexion->select($consultaMonedas, [$id_usuario]);

        if (empty($resultado)) {
            throw new Exception('No se encontró al usuario.');
        }
        $monedas_actuales = (int)$resultado[0]['contador_monedas'];

        // Verificar monedas mínimas y cartones máximos desde la tabla partida
        $consultaPartida = "SELECT monedas_minimas, maximo_cartones FROM partida WHERE codigo_sala = ?";
        $resultadoPartida = $conexion->select($consultaPartida, [$codigo_partida]);

        if (empty($resultadoPartida)) {
            throw new Exception('No se encontró la partida.');
        }

        $monedas_minimas = (int)$resultadoPartida[0]['monedas_minimas'];
        $maximo_cartones = (int)$resultadoPartida[0]['maximo_cartones'];

        // Validaciones
        if ($monedas < $monedas_minimas) {
            throw new Exception("La cantidad mínima de monedas para apostar es $monedas_minimas.");
        }
        if ($cartones > $maximo_cartones) {
            throw new Exception("El número máximo de cartones es $maximo_cartones.");
        }
        if ($monedas_actuales < $monedas) {
            throw new Exception('No tienes suficientes monedas para apostar.');
        }

        // Actualizar monedas y cartones
        $conexion->getPdo()->beginTransaction();

        $queryPartidaRol = "UPDATE usuario_partida_rol 
                            SET monedas_apostar = ?, numero_cartones = ? 
                            WHERE id_usuario = ? AND id_partida = (SELECT id_partida FROM partida WHERE codigo_sala=?)";
        $conexion->update($queryPartidaRol, [$monedas, $cartones, $id_usuario, $codigo_partida]);

        $monedas_restantes = $monedas_actuales - $monedas;
        $queryUsuario = "UPDATE usuario SET contador_monedas = ? WHERE id_usuario = ?";
        $conexion->update($queryUsuario, [$monedas_restantes, $id_usuario]);

        $conexion->getPdo()->commit();

        echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
    } else {
        throw new Exception('Método no soportado.');
    }
} catch (Exception $e) {
    if ($conexion->getPdo()->inTransaction()) {
        $conexion->getPdo()->rollBack();
    }
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
