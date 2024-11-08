
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Cargar el archivo JSON
$carton = file_get_contents('../json/comprarCarton.json');
if ($carton === false) {
    echo json_encode(['error' => 'No se pudo cargar el amigos php.']);
    exit;
}
echo $carton;
