<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Content-Type: application/json");
echo json_encode(['logout' => true, 'mensaje' => 'Sesión cerrada correctamente']);
exit();