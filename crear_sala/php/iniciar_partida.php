<?php
session_start();
ob_clean();
header('Content-Type: application/json');

// Incluir archivo de conexión
require '../../conexion_BD/conexion.php';

try {
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    if (
        !isset($data['monedasPorJugador'], $data['cartonesPorJugador'], $data['cartonSeleccionado'], $data['botonSeleccionado'], $data['codigoPartida']) ||
        !is_numeric($data['monedasPorJugador']) ||
        !is_numeric($data['cartonesPorJugador']) ||
        !is_numeric($data['cartonSeleccionado']) || // Validar como string
        !is_string($data['botonSeleccionado']) || // Validar como string
        !is_string($data['codigoPartida']) // Validar como string
    ) {
        error_log('Error de validación: Datos incompletos o inválidos.');
        echo json_encode(['success' => false, 'message' => 'Datos incompletos o inválidos.']);
        exit;
    }

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }

    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION['usuario_id'];
    error_log("ID de usuario desde sesión: " . $id_usuario);

    // Verificar si se envió el formulario por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos enviados por POST
        $monedasPorJugador = isset($data['monedasPorJugador']) ? intval($data['monedasPorJugador']) : null;
        $cartonesPorJugador = isset($data['cartonesPorJugador']) ? intval($data['cartonesPorJugador']) : null;
        $cartonSeleccionado = isset($data['cartonSeleccionado']) ? $data['cartonSeleccionado'] : null;
        $botonSeleccionado = isset($data['botonSeleccionado']) ? $data['botonSeleccionado'] : null;
        $codigoPartida = isset($data['codigoPartida']) ? $data['codigoPartida'] : null;

        // Instanciar la conexión a la base de datos
        $conexion = new Conexion();

        // Verificar si el código de partida existe en la base de datos
        $queryCheckPartida = "
            SELECT 1 
            FROM partida 
            WHERE codigo_sala = :codigo_partida
        ";

        $paramsCheckPartida = [':codigo_partida' => $codigoPartida];
        $stmtCheck = $conexion->select($queryCheckPartida, $paramsCheckPartida);

        if (count($stmtCheck) == 0) {
            echo json_encode(['success' => false, 'message' => 'No se encontró una partida con el código proporcionado']);
            error_log("Error: No se encontró una partida con el código proporcionado.");
            exit;
        }

        // Realizar UPDATE para iniciar la partida
        $queryUpdatePartida = "
            UPDATE partida 
            SET 
                monedas_minimas = :monedas_minimas,
                maximo_cartones = :maximo_cartones,
                forma_carton = :forma_carton,
                estado = 'iniciada'
            WHERE codigo_sala = :codigo_partida";

        $paramsUpdatePartida = [
            ':monedas_minimas' => $monedasPorJugador,
            ':maximo_cartones' => $cartonesPorJugador,
            ':forma_carton' => $cartonSeleccionado,
            ':codigo_partida' => $codigoPartida
        ];

        $stmt = $conexion->update($queryUpdatePartida, $paramsUpdatePartida);
        $rowsAffected = $stmt->rowCount();

        error_log("esta actualizado");

        if ($rowsAffected == 0) {
            echo json_encode(['success' => false, 'message' => 'No se actualizó la partida']);
            error_log("Error: No se actualizó la partida.");
            exit;
        }

        // Determinar el rol basado en el botón seleccionado
        $id_rol = ($botonSeleccionado === 'jugador') ? 1 : 2;

        // Insertar en la tabla usuario_partida_rol
        $queryRol = "
            INSERT INTO usuario_partida_rol (id_usuario, id_partida, id_rol) 
            VALUES (
                :id_usuario,
                (SELECT id_partida FROM partida WHERE codigo_sala = :codigo_sala), 
                :id_rol
            )";

        $paramsRol = [
            ':id_usuario' => $id_usuario,
            ':codigo_sala' => $codigoPartida,
            ':id_rol' => $id_rol
        ];

        $conexion->insert($queryRol, $paramsRol);
        error_log("paso todo bien");
        echo json_encode(['success' => true, 'message' => 'Partida iniciada correctamente y rol registrado']);      
        exit;
    } else {
        error_log("No es post");
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }
} catch (Exception $e) {
    error_log("pinche cosa");
    error_log("Excepcion: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);   
}
