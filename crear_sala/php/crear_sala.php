
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Cargar el archivo JSON
$cartones = file_get_contents('../cartones_sala.json');
if ($cartones === false) {
    echo json_encode(['error' => 'No se pudo cargar los cartones php.']);
    exit;
}
echo $cartones;
