    <?php
    require_once '../../../conexion_BD/conexion.php'; // Cambiado a require_once

    function agregarArticulosDesbloqueadosPorDefecto($pdo, $idUsuario) {
        try {
            // Obtener los artículos desbloqueados por defecto
            $queryArticulos = "SELECT id_articulo FROM articulo WHERE etiqueta = 'desbloqueado_por_defecto'";
            $stmt = $pdo->prepare($queryArticulos);
            $stmt->execute();
            $articulos = $stmt->fetchAll();
    
            // Verifica si se encontraron artículos
            if (empty($articulos)) {
                throw new Exception("No se encontraron artículos con etiqueta 'desbloqueado_por_defecto'");
            }
    
            // Insertar los artículos en la tabla usuario_articulo
            $queryInsert = "INSERT INTO usuario_articulo (id_usuario, id_articulo, fecha_compra) VALUES (?, ?, NOW())";
            $stmtInsert = $pdo->prepare($queryInsert);
    
            foreach ($articulos as $articulo) {
                $stmtInsert->execute([$idUsuario, $articulo['id_articulo']]);
            }
    
            return "Artículos desbloqueados por defecto añadidos al usuario $idUsuario.";
        } catch (Exception $e) {
            error_log("Error al agregar artículos desbloqueados: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }
    
