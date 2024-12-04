<?php
header('Content-Type: application/json');
session_start();
require '../../conexion_BD/conexion.php';

// Función para generar un código aleatorio de 6 dígitos
function generarCodigo($longitud = 6): string
{
    return substr(str_shuffle("0123456789"), 0, $longitud);
}

try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    if (!$pdo) {
        throw new Exception('Error al conectar con la base de datos');
    }

    // Obtener ID del usuario desde la sesión
    $id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;

    // Generar un código único para la partida
    do {
        $codigo = generarCodigo();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM partida WHERE codigo_sala = :codigo");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $existe = $stmt->fetchColumn();
    } while ($existe > 0);

    $estado = "registrada";

    // Insertar la partida en la base de datos
    $query = "INSERT INTO partida (codigo_sala, monedas_minimas, maximo_cartones, id_creador, estado) 
              VALUES (:codigo, 0, 0, :id_creador, :estado)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':codigo' => $codigo,
        ':id_creador' => $id_usuario,
        ':estado' => $estado
    ]);

    // Guardar el código de la partida en la sesión
    $_SESSION['codigo_partida'] = $codigo;

    echo json_encode([
        'success' => true,
        'codigo_sala' => $codigo
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
