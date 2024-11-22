<?php
require '../conexion_BD/conexion.php';

// Debug información
echo "Datos recibidos:<br>";
echo "GET: "; print_r($_GET);
echo "<br>URL: " . $_SERVER['REQUEST_URI'];
echo "<br>Query String: " . $_SERVER['QUERY_STRING'];

// Consultar la base de datos para ver los tokens
$pdo = new Conexion();
$stmt = $pdo->conectar()->query("SELECT correo, token_verificacion FROM usuario");
echo "<br><br>Tokens en base de datos:<br>";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Email: " . $row['correo'] . " - Token: " . $row['token_verificacion'] . "<br>";
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    echo "Token recibido: " . $token . "<br>";
    $pdo = new Conexion();
    
    try {
        $stmt = $pdo->conectar()->prepare("UPDATE usuario SET verificado = TRUE, token_verificacion = NULL 
                                         WHERE token_verificacion = ?");
        $resultado = $stmt->execute([$token]);
        
        if ($resultado && $stmt->rowCount() > 0) {
            echo "<h1>¡Registro completado!</h1>";
            echo "<p>Tu cuenta ha sido verificada exitosamente.</p>";
            echo "<p><a href='/Bingo-sauro/login/inicioSesion/InicioSesion.html'>Iniciar Sesión</a></p>";
        } else {
            echo "<h1>Error</h1>";
            echo "<p>Token inválido o ya utilizado.</p>";
        }
    } catch (PDOException $e) {
        echo "<h1>Error</h1>";
        echo "<p>Ha ocurrido un error al verificar tu cuenta.</p>";
    }
} else {
    echo "<h1>Error</h1>";
    echo "<p>Token no proporcionado.</p>";
    echo "<p>URL actual: " . $_SERVER['REQUEST_URI'] . "</p>";
}
?> 