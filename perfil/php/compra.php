<?php
require_once '../../conexion_BD/conexion.php'; // Incluye el archivo de la clase Conexion

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
} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error en la conexión a la base de datos: ' . $e->getMessage()]);
    exit;
}

// Obtener y decodificar los datos enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Validar los datos recibidos
if (!$data || !isset($data['idArticulo'], $data['precioArticulo'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'Datos inválidos o incompletos.']);
    exit;
}

$idArticulo = $data['idArticulo'];
$precioArticulo = $data['precioArticulo'];

// Función para realizar la compra
function realizarCompra($pdo, $idUsuario, $idArticulo, $precioArticulo)
{
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
                echo json_encode(['exito' => false, 'mensaje' => 'Error al actualizar las monedas.']);
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
            echo json_encode(['exito' => false, 'mensaje' => 'No tienes suficientes monedas.']);
        }
    } catch (Exception $e) {
        echo json_encode(['exito' => false, 'mensaje' => 'Error en la compra: ' . $e->getMessage()]);
        exit;
    }
}

// Llamar a la función de compra
realizarCompra($pdo, $idUsuario, $idArticulo, $precioArticulo);
?>
