    <?php
    session_start();
    require '../../conexion_BD/conexion.php';

    try {
        $conexion = new Conexion();

        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['usuario_id'])) {
            error_log("Error: Usuario no autenticado.");
            throw new Exception('Usuario no autenticado');
        }

        // Obtener el ID del usuario desde la sesión
        $id_usuario = $_SESSION['usuario_id'];
        error_log("ID de usuario: " . $id_usuario); // Registrar el ID del usuario

        // Verificar si el usuario está en la tabla usuario_partida_rol
        $query = "SELECT COUNT(*) as total FROM usuario_partida_rol WHERE id_usuario = ?";
        $result = $conexion->select($query, [$id_usuario]);

        if ($result && $result[0]['total'] > 0) {
            error_log("Usuario está en la partida."); // Registrar que el usuario está en la partida

            // Si el usuario está en la partida, verificar el estado de la partida
            $query_estado = "SELECT estado FROM partida WHERE id_partida = (SELECT id_partida FROM partida WHERE codigo_sala = ? LIMIT 1)";
            $estado_result = $conexion->select($query_estado, [$codigoSala]);

            if ($estado_result && $estado_result[0]['estado'] === 'iniciada') {
                // Si el estado de la partida es "iniciada", redirigir al usuario con JavaScript
                error_log("La partida está iniciada.");
                echo json_encode(['success' => true, 'message' => 'Usuario sigue en la partida.', 'redirect' => true]);
            } else {
                // Si la partida no está iniciada
                error_log("La partida no está iniciada.");
                echo json_encode(['success' => true, 'message' => 'Usuario sigue en la partida, pero la partida no está iniciada.']);
            }
        } else {
            error_log("Usuario no está en la partida.");
            echo json_encode(['success' => false, 'message' => 'Usuario no está en la partida.']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage()); // Registrar cualquier error
        echo json_encode(['error' => 'Error: ' . $e->getMessage(), 'success' => false]);
    }
    ?>
