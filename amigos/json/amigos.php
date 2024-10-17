<?php
header('Content-Type: application/json'); // Establecer el tipo de contenido a JSON

// Ruta del archivo JSON
$jsonFile = '/amigos/json/amigos.json'; // Ajusta esta ruta según donde esté tu archivo JSON

// Verificar si el archivo JSON existe
if (file_exists($jsonFile)) {
    // Cargar el contenido del archivo JSON
    $jsonData = file_get_contents($jsonFile);
    echo $jsonData; // Devolver los datos JSON
} else {
    // Si el archivo no existe, devolver un error
    echo json_encode(['error' => 'Archivo no encontrado']);
}
?>
