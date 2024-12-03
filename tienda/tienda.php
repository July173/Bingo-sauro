<?php
session_start();
include '../conexion_BD/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>

    <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css">
    <link rel="stylesheet" href="../tienda/css/tienda.css" />
    <link rel="stylesheet" href="../generales/configuracion/posicion.css">
    <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
    <link rel="stylesheet" href="../generales/fontawesome/css/all.min.css">
    <script src="../generales/bootstrap/js/bootstrap.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />

</head>

<body class="container">

    <div id="contenedor">

        <div class="hojas">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>

        <div class="hojas-2">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>

        <div class="hojas-3">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>
        <div class="cuadro">

            <div class="icon-container">
                <!-- Botón de Configuración (Engranaje) -->
                <a href="../generales/configuracion/configuracion.php" class="icon">
                <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png"
                        alt="settings" />
                </a>
            </div>
            <div id='monedas'></div>
            <script src="../generales/monedas/js/conexion-monedas.js"></script>
            <script>
                cargarContenido();
            </script>
            <div class="logo"></div>
            <div class="contenedor-gris">
                <div class="titulo-contenedor">Ofertas</div>
                <div class="subtitulos">
                    <p class="sub "> Recompensas diarias </p>
                </div>



                <div class="contenedor-dias">
                    <div>
                        <table class="reward-table">
                            <tr>
                                <td>
                                    <div class="reward-container">
                                        <div class="reward-header">AYER</div>
                                        <div class="circle-container">
                                            <dotlottie-player id="rewardAnimation1"
                                                src="https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json"
                                                background="transparent" speed="1" style="width: 150px; height: 150px;"
                                                loop autoplay>
                                            </dotlottie-player>
                                        </div>
                                    </div>
                                    <div id="rewardMessage1" style="display: none;"></div>
                                </td>
                                <td>
                                    <div class="reward-container">
                                        <div class="reward-header">HOY</div>
                                        <div class="circle-container">
                                            <dotlottie-player id="rewardAnimation2"
                                                src="https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json"
                                                background="transparent" speed="1" style="width: 150px; height: 150px;"
                                                loop autoplay>
                                            </dotlottie-player>
                                        </div>
                                    </div>
                                    <div id="rewardMessage2" style="display: none;"></div>
                                </td>
                                <td>
                                    <div class="reward-container">
                                        <div class="reward-header">MAÑANA</div>
                                        <div class="circle-container">
                                            <dotlottie-player id="rewardAnimation3"
                                                src="https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json"
                                                background="transparent" speed="1" style="width: 150px; height: 150px;"
                                                loop autoplay>
                                            </dotlottie-player>
                                        </div>
                                    </div>
                                    <div id="rewardMessage3" style="display: none;"></div>
                                </td> 
                            </tr>
                            
                        </table>
                    </div>
                    
                    <div id="congratulationsMessage" class="congratulations-message" style="display: none;"></div>
                </div>


                <div class="subtitulos2">
                    <p class="sub ">Cambiar de colores de cartones</p>
                </div>
                

                <div class="contenedorDelContenedorDeCartones">
                    <div id="contenedorCartones"></div>
                </div>

            </div>

            <div id='navbar-container'></div>
            <script src="../generales/barra_navegacion/navbar.js"></script>
            <script>
                loadNavbar();
            </script>
        </div>

        <script src="src-js/tienda.js"></script>
        <script src="../tienda/src-js/recompensa-diaria.js"></script>
        <script src="../generales/monedas/js/obtener-monedas.js"></script>

        <div id="cofres"></div>

</body>
</html>  