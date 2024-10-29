<?php
require_once '../../../conexion_BD/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $nombre = $_POST['username'];
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO credenciales (correo, nombre, contrasena) VALUES (?, ?, ?)");
        $stmt->execute([$correo, $nombre, $contrasena]);
        
        echo "Usuario registrado con éxito";
        header("Location: http://localhost/Bingo-sauro/login/inicioSesion/InicioSesion.html");
    } catch(PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido";
}
?>
