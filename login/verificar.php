<?php
require '../conexion_BD/conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $pdo = new Conexion();
    
    try {
        // Verificar y actualizar el estado del usuario
        $stmt = $pdo->conectar()->prepare("UPDATE usuario SET verificado = TRUE WHERE token_verificacion = ?");
        $stmt->execute([$token]);
        
        if ($stmt->rowCount() > 0) {
            // Redirigir al inicio de sesión
            header('Location: /Bingo-sauro/login/inicioSesion/InicioSesion.html');
            exit();
        } else {
            echo "<h1>Error</h1>";
            echo "<p>Token inválido o ya utilizado.</p>";
        }
    } catch (PDOException $e) {
        echo "<h1>Error</h1>";
        echo "<p>Error al verificar la cuenta.</p>";
    }
} else {
    echo "<h1>Error</h1>";
    echo "<p>Token no proporcionado.</p>";
}
?> 