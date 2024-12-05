<?php
session_start();
header('Content-Type: application/json');


// Ejemplo de datos que quieres devolver
$response = [
    'success' => true,
    'message' => 'Partida iniciada correctamente.'
];

// Devuelve la respuesta como JSON
echo json_encode($response);
error_log(print_r($response, true)); // Para debugging en error_log


// Incluir archivo de conexión
require '../../conexion_BD/conexion.php';

try {
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // **Validación inicial de datos**
    if (
        !isset($data['monedasPorJugador'], $data['cartonesPorJugador'], $data['cartonSeleccionado'], $data['botonSeleccionado'], $data['codigoPartida']) ||
        !is_numeric($data['monedasPorJugador']) ||
        !is_numeric($data['cartonesPorJugador']) ||
        !is_string($data['cartonSeleccionado']) || // Validar como string
        !is_string($data['botonSeleccionado']) || // Validar como string
        !is_string($data['codigoPartida']) // Validar como string
    ) {
        error_log('Error de validación: Datos incompletos o inválidosss.');
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

   if (is_string($cartonSeleccionado)) {
    // Si es un string, intenta decodificarlo
    $cartonSeleccionado = json_decode($cartonSeleccionado, true);
}

if (!is_array($cartonSeleccionado) || !isset($cartonSeleccionado['id'])) {
    error_log("cartonSeleccionado no tiene un formato válido o no contiene 'id'.");
    echo json_encode(['success' => false, 'message' => 'cartonSeleccionado inválido.']);
    exit;
}


        // Instanciar la conexión a la base de datos
        $conexion = new Conexion();

        // (El resto del código permanece igual)

        // Si no se proporcionó el código de partida, obtenerlo de la base de datos
        if (empty($codigoPartida)) {
            $queryObtenerCodigo = "
                SELECT codigo_sala 
                FROM partida 
                WHERE id_creador = :id_usuario
                ORDER BY id_partida DESC LIMIT 1
            ";

            $paramsObtenerCodigo = [':id_usuario' => $id_usuario];
            $resultadoCodigo = $conexion->select($queryObtenerCodigo, $paramsObtenerCodigo);

            if (!empty($resultadoCodigo)) {
                $codigoPartida = $resultadoCodigo[0]['codigo_sala'];
                error_log("Código de partida obtenido de la base de datos: $codigoPartida");
            } else {
                echo json_encode(['success' => false, 'message' => 'No se encontró ninguna partida asociada al usuario.']);
                error_log("No se encontró ninguna partida asociada al usuario.");
                exit;
            }
        }

        // Validar que los datos no estén vacíos
        if ($monedasPorJugador === null || $cartonesPorJugador === null || $cartonSeleccionado === null || !$cartonSeleccionado['id'] || $botonSeleccionado === null) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos o inválidos']);
            error_log("Error de validación: Datos incompletos o inválidos.");
            exit;
        }

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
            ':forma_carton' => $cartonSeleccionado['id'],
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

        error_log("mira el rol");

        // Insertar en la tabla usuario_partida_rol
        $queryRol = "
            INSERT INTO usuario_partida_rol (id_usuario, id_partida, id_rol) 
            VALUES (
                :id_usuario,
                (SELECT id_partida FROM partida WHERE codigo_sala = :codigo_sala), 
                :id_rol
            )";

            error_log($queryRol);

        $paramsRol = [
            ':id_usuario' => $id_usuario,
            ':codigo_sala' => $codigoPartida,
            ':id_rol' => $id_rol
        ];
        error_log("los atributos son " .$id_usuario );
        error_log("los atributos son " .$codigo_sala );
        error_log("los atributos son " .$id_rol);

        $conexion->insert($queryRol, $paramsRol);

        echo json_encode(['success' => true, 'message' => 'Partida iniciada correctamente y rol registrado']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    error_log("Excepción: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);   
}
