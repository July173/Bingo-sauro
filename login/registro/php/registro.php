<?php
// Incluir el archivo de conexión
include 'C:/xampp/htdocs/Bingo-sauro/conexion_BD/conexion.php'; // Asegúrate de que la ruta sea correcta

// Depuración: Verifica el contenido de $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Muestra el contenido de $_POST
    echo "</pre>";
}

// Preparar la consulta
$stmt = $pdo->prepare("INSERT INTO usuarios (primer_nombre, email, contrasena, fecha_registro) VALUES (?, ?, ?, NOW())");

// Obtener datos del formulario
$primer_nombre = $_POST['primer_nombre'];
$email = $_POST['email'];
$contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

// Ejecutar la consulta
if ($stmt->execute([$primer_nombre, $email, $contrasena])) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $stmt->errorInfo()[2]; // Muestra el error de la consulta
}

// Cerrar la conexión (no es necesario con PDO, pero puedes hacerlo)
$pdo = null; // Esto cierra la conexión
?>