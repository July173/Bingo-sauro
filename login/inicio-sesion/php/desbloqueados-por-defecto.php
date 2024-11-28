<?php
require_once 'Conexion.php';

function agregarArticulosDesbloqueadosPorDefecto($pdo, $idUsuario) {
    try {
        // Obtener los artículos desbloqueados por defecto
        $queryArticulos = "SELECT id_articulo FROM articulo WHERE etiqueta = 'desbloqueado_por_defecto'";
        $stmt = $pdo->prepare($queryArticulos);
        $stmt->execute();
        $articulos = $stmt->fetchAll();

        // Insertar los artículos en la tabla usuario_articulo
        $queryInsert = "INSERT INTO usuario_articulo (id_usuario, id_articulo, fecha_compra) VALUES (?, ?, NOW())";
        $stmtInsert = $pdo->prepare($queryInsert);

        foreach ($articulos as $articulo) {
            $stmtInsert->execute([$idUsuario, $articulo['id_articulo']]);
        }

        return "Artículos desbloqueados por defecto añadidos al usuario $idUsuario.";
    } catch (Exception $e) {
        return "Error al agregar los artículos desbloqueados por defecto: " . $e->getMessage();
    }
}
