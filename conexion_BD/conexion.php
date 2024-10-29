<?php
// Configuración de la conexión
$host = "localhost";
$dbname = "proyecto-bingo-sauro";
$user = "root";  // Cambiado de "pma" a "root"
$password = "";  // Asegúrate de que esta sea la contraseña correcta para el usuario root
$puerto = "3305";

try {
    // Crear la conexión PDO
    $dsn = "mysql:host=$host;port=$puerto;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    
    // Configurar el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // La conexión se ha establecido correctamente
    echo "Conexión exitosa a la base de datos.";

} catch(PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>