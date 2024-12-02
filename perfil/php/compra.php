<?php
require_once '../../conexion_BD/conexion.php'; // Incluye el archivo de la clase Conexion

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
    die("Error: Usuario no autenticado");
}

// Opcional: Obtener información del usuario
$idUsuario = $_SESSION['usuario_id'];

$data = json_decode(file_get_contents('php://input'), true);

// Depuración
if (!$data) {
    error_log("Error: No se recibieron datos válidos. Datos recibidos: " . file_get_contents('php://input'));
    die("Error: No se recibieron datos válidos.");
}

$idArticulo = $data['idArticulo'];
$precioArticulo = $data['precioArticulo'];
if (!isset($data['idArticulo'], $data['precioArticulo'])) {
    die("Error: Claves faltantes o inválidas en los datos enviados.");
}


function realizarCompra($pdo, $idUsuario, $idArticulo, $precioArticulo) {
    try {
        // Comprobar si el usuario tiene suficientes monedas
        $stmt = $pdo->prepare("SELECT contador_monedas FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
        $usuario = $stmt->fetch();

        if ($usuario && $usuario['contador_monedas'] >= $precioArticulo) {
            // Descontar las monedas
            $stmt = $pdo->prepare("UPDATE usuario SET contador_monedas = contador_monedas - ? WHERE id_usuario = ?");
            $stmt->execute([$precioArticulo, $idUsuario]);

            if ($stmt->rowCount() === 0) {
                echo json_encode(['exito' => false, 'mensaje' => 'Error al actualizar las monedas']);
                exit;
            }

            // Insertar el artículo comprado en la tabla usuario_articulo
            $stmt = $pdo->prepare("INSERT INTO usuario_articulo (id_usuario, id_articulo, fecha_compra) VALUES (?, ?, NOW())");
            $stmt->execute([$idUsuario, $idArticulo]);

            // Obtener las monedas restantes
            $stmt = $pdo->prepare("SELECT contador_monedas FROM usuario WHERE id_usuario = ?");
            $stmt->execute([$idUsuario]);
            $usuarioActualizado = $stmt->fetch();

            // Devolver éxito y monedas restantes
            echo json_encode([
                'exito' => true,
                'monedas_restantes' => $usuarioActualizado['contador_monedas']
            ]);
        } else {
            // No tiene suficientes monedas
            echo json_encode(['exito' => false, 'mensaje' => 'No tienes suficientes monedas']);
        }
    } catch (Exception $e) {
        echo json_encode(['exito' => false, 'mensaje' => 'Error en la compra: ' . $e->getMessage()]);
    }
}

// Llamar a la función de compra
realizarCompra($pdo, $idUsuario, $idArticulo, $precioArticulo);
?>
