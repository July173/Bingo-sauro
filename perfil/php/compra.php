<?php
require_once '../../conexion_BD/conexion.php';

// Recuperar los datos enviados por la solicitud AJAX
$data = json_decode(file_get_contents('php://input'), true);
$idUsuario = $data['idUsuario'];
$idArticulo = $data['idArticulo'];
$precioArticulo = $data['precioArticulo'];

function realizarCompra($pdo, $idUsuario, $idArticulo, $precioArticulo) {
    try {
        // Comprobar si el usuario tiene suficientes monedas
        $stmt = $pdo->prepare("SELECT contador_monedas FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
        $usuario = $stmt->fetch();

        if ($usuario['contador_monedas'] >= $precioArticulo) {
            // Descontar las monedas
            $stmt = $pdo->prepare("UPDATE usuario SET contador_monedas = contador_monedas - ? WHERE id_usuario = ?");
            $stmt->execute([$precioArticulo, $idUsuario]);

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
