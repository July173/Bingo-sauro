<?php
header('Content-Type: application/json');

// Cargar el archivo JSON
$historial = file_get_contents('/historial/historial.json');
echo $historial;
?>