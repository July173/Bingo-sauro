<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Cargar el archivo JSON
$historial = file_get_contents('../../historial/historial.json');
if ($historial === false) {
    echo json_encode(['error' => 'No se pudo cargar el historial php.']);
    exit;
}
echo $historial;
