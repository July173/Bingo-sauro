<?php
header('Content-Type: application/json');
require '../../conexion_BD/conexion.php';
session_start();

// Opcional: Obtener información del usuario para mostrar en la página
$id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : '0';

// Instanciar conexión
$conexion = new Conexion();
$pdo = $conexion->conectar();

// Validar conexión
if (!$pdo) {
    echo json_encode(['error' => 'Error al conectar con la base de datos', 'success' => false]);
    exit();
}

// Función para generar un código aleatorio de 6 caracteres
function generarCodigo($longitud = 6): string
{
    return substr(str_shuffle("0123456789"), 0, $longitud);
}

try {
    $resultado = 0;

    // Generar un código único
    do {
        $codigo = generarCodigo();
        $codigoConsultado = $pdo->prepare("SELECT COUNT(*) as total FROM partida WHERE codigo_sala = :codigo");
        $codigoConsultado->bindParam(':codigo', $codigo);
        $codigoConsultado->execute();
        $resultado = $codigoConsultado->fetchColumn();
    } while ($resultado > 0);

    // Insertar nuevo código en la base de datos
    $query = "INSERT INTO partida (codigo_sala, monedas_minimas, maximo_cartones,id_creador) VALUES (:codigo, 0, 0,:id_creador)";
    $params = [
        ':codigo' => $codigo,
        ':id_creador' => $id_usuario
    ];
    
    $insertado = $pdo->prepare($query);
    $insertado->execute($params);
    

    // Obtener el ID del último registro insertado
    $lastId = $pdo->lastInsertId();

    // Retornar JSON válido
    echo json_encode([
        'codigo_sala' => $codigo,
        'id_creador'=> $id_usuario,
        'last_id' => $lastId,
        'success' => true
    ]);

    
    
} catch (PDOException $e) {
    // Manejar errores de base de datos
    echo json_encode([
        'error' => 'Error en la base de datos: ' . $e->getMessage(),
        'success' => false
    ]);
}
