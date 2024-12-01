<?php
require_once '../../../conexion_BD/conexion.php';
// require_once 'desbloqueados-por-defecto.php';

try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();
    
    $idUsuario = 6; // Cambia esto por el ID de usuario real
    $resultado = agregarArticulosDesbloqueadosPorDefecto($pdo, $idUsuario);

    echo $resultado;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
