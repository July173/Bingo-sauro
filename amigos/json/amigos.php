<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Cargar el archivo JSON
$amigos = file_get_contents('../json/amigos.json');
if ($amigos === false) {
    echo json_encode(['error' => 'No se pudo cargar el amigos php.']);
    exit;
}
echo $amigos;
