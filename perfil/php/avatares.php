<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Cargar el archivo JSON
$avatares = file_get_contents('../JSON/avatarComprar.json');
if ($avatares === false) {
    echo json_encode(['error' => 'No se pudo cargar el amigos php.']);
    exit;
}
echo $avatares;
