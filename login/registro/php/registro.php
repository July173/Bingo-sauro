<?php
require_once '../../../conexion_BD/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $nombre = $_POST['username'];
    $contrasena = $_POST['password'];
    $terminos_condiciones = isset($_POST['terminos_condiciones']) ? $_POST['terminos_condiciones'] : '0';

    // Verificar si hay campos vacíos
    if (empty($correo) || empty($nombre) || empty($contrasena)) {
        echo "Error: Todos los campos son obligatorios."; // Mensaje de error
        return; // Detener la ejecución si hay campos vacíos
    }

    try {
        // Verificar si el correo ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM credenciales WHERE correo = ?");
        $stmt->execute([$correo]);
        $existe = $stmt->fetchColumn();

        if ($existe > 0) {
            echo "<div class='error'>Error: El correo ya está registrado.</div>"; // Mensaje de error debajo del campo
        } else {
            $stmt = $pdo->prepare("INSERT INTO credenciales (correo, nombre, contrasena, terminos_condiciones) VALUES (?, ?, ?, ?)");
            $stmt->execute([$correo, $nombre, $contrasena, $terminos_condiciones]);
            
            echo "Usuario registrado con éxito";
            header("Location: http://localhost/Bingo-sauro/login/inicioSesion/InicioSesion.html");
        }
    } catch(PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido";
}
?>