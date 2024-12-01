<?php
// unirse_partida.php
require '../../conexion_BD/conexion.php';

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
// $foto = $_POST['foto'];

// Verifica que el código existe
$stmt = $conn->prepare("SELECT id_partida FROM partida WHERE codigo_sala = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($partida_id);
    $stmt->fetch();

    // Inserta al jugador en la tabla
    $stmtJugador = $conn->prepare("INSERT INTO jugadores (partida_id, nombre) VALUES (?, ?)");
    $stmtJugador->bind_param("iss", $partida_id, $nombre, $foto);

    if ($stmtJugador->execute()) {
        echo json_encode(['success' => true, 'nombre' => $nombre]);
    } else {
        echo json_encode(['error' => 'Error al unirse a la partida', 'success' => false]);
    }

    $stmtJugador->close();
} else {
    echo json_encode(['error' => 'Código de partida no válido', 'success' => false]);
}

$stmt->close();
$conn->close();
?>
