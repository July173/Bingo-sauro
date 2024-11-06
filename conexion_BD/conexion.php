<?php
// Configuración de la conexión
$host = "bwbup4izlyky4o7s56rs-mysql.services.clever-cloud.com";
$dbname = "bwbup4izlyky4o7s56rs";
$user = "ueux843bklbuh0jv";  // usuario root
$password = "kJ2Xvm2k1YPrn9gEHKK2";  // contraseña de el usuario root
$puerto = "3306";

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