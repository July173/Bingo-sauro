
<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
    exit();
}

// Opcional: Obtener información del usuario para mostrar en la página
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monedas y Trofeos</title>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/monedas-trofeos.css">
</head>
<body>
    <div id="mostrar-esto">
        <!-- Contenedor del contador -->
        <div class="counter-container">
            <!-- Contador 25 -->
            <div class="separador">
                <div class="counter">
                    <div id="cuadro_monedas"></div>
                    <img src="../generales/img/dinomonedas.png" >
                </div>
            </div>

            <!-- Contador 1 con modal -->
            <div class="separador fondo">
                <div class="counter counter-1 " data-bs-toggle="modal" data-bs-target="#dinoModal">
                    <span>0</span>
                    <img src="../generales/img/dinoTrofeos.png" class="imagen-trofeo" >
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="dinoModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="dinoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content estilo-modal">
                    
                    <div class="modal-body">
                        <div class="custom-close" data-bs-dismiss="modal" aria-label="Close"></div>

                        <p class="letra">Los dino-trofeos se obtienen al ganar y representan estas partidas ganadas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../generales/bootstrap/js/bootstrap.js"></script>
    <script src="js/obtener-monedas.js"></script>
</body>
</html>
