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
    <title>Configuracion</title>
    <link rel="stylesheet" href="../configuracion/config.css">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../generales/bootstrap/css/bootstrap.css">
</head>
<body class="container">
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
        <div class="dinochibi"></div>
        <div class="header">
            <h2 class="settings-title">AJUSTES</h2>
        </div>
        <div class="boton">
            <img class="close-btn" onclick="redirectToPreviousPage();" width="48" height="48"
                src="../../generales/img/cerrar.png" alt="cross-mark-button-emoji" />
        </div>
        <div class="mascot"></div>

        <div class="contenedor-recuadros">
            <div class="option">
                <img width="35" height="30" src="https://img.icons8.com/ios-filled/50/audio-wave--v1.png"
                    alt="audio-wave--v1" />
                <span class="option-text-2"> <b> Sonido </b></span>
                <div class="toggle active" id="soundToggle"></div>
            </div>

            <button class="botonn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <img width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/terms-and-conditions.png"
                    alt="terms-and-conditions" /> <b>Términos y condiciones</b>
            </button>
            
            <!-- Botón para abrir el modal de Ayuda y Soporte -->
            <button class="botonn" data-bs-toggle="modal" data-bs-target="#modalDos">
                <img width="30" height="30" src="https://img.icons8.com/ios-filled/50/help.png" alt="help" />
                <b> Ayuda y soporte </b>
            </button>
            
            <!-- Modal de Términos y Condiciones -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content bg-transparent">
                        <div class="modal-header">
                            <h1 class="modal-title fs-3" id="staticBackdropLabel">Términos y condiciones</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="display:none;"></button>
                          <div class="custom-close" data-bs-dismiss="modal" aria-label="Close"></div>
                            <img src="../../Generales/img/logo.png" alt="Logo" class="logoModal">
                        </div>
                    
                        <div class="modal-body">
                            <div class="contexto">
                                El juego Bingo-Saurio está creado con fines de entretenimiento y diversión para poder compartir un
                                rato
                                agradable con tus familiares o amigos
                                Este juego podra ser jugado por toda la población, tanto niños como personas adultas ya que está
                                orientedo para la diversión de todos, el único requisito es registrarse mediante un correo
                                electrónico.
                                Se espera que este juego sea jugando mientras los jugadores estén cercanos unos de otros para que
                                estos
                                se puedan comunicar fácilmente y sea más fácil la interacción entre ellos y así el juego tenga una
                                mayor
                                taza de diversión.
                                Al ganar una partida el jugador ganador obtendrá una recompensa con monedas del propio juego que
                                después
                                podra gastar comprando los objetos de la tienda en el juego, en caso de no ganar la partida el jugador
                                no obtendrá ninguna recompensa. También habrán premios diarios por ingresar todos los días.
                                Tus datos personales se utilizan solo para entender nuestra audiencia y mejorar la experiencia de
                                juego,
                                no compartiremos tus datos personales con terceros sin tu consentimiento explícito.
                                En caso de que se llegase a presentar un conflicto entre los jugadores, estos mismos serán los que
                                tendrán que resolverlo entre ellos de manera respetuosa y pacifica, el creador del juego no se hace
                                responsable de conflictos entre jugadores.
                                El creador del juego puede hacer cambios y actualizaciones en el juego cuando sea necesario para
                                mejorar
                                la experiencia de juego o corregir errores.
                                Los jugadores serán notificados de cualquier cambio significativo en los Términos y Condiciones.
                                Al registrarse y jugar Bingo-Saurio, los jugadores aceptan estos Términos y Condiciones en su
                                totalidad.
                                Es responsabilidad del jugador leer y comprender estos Términos y Condiciones antes de jugar.
                            </div>
                            <img src="../../generales/img/bingo.png" alt="Bolas que dicen bingo" class="Bingo">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal de Ayuda y Soporte -->
            <div class="modal fade" id="modalDos" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="modalDosLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content bg-transparent">
                        <div class="modal-header">
                            <h1 class="modal-title fs-1 id="modalDosLabel">Ayuda y soporte</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="display:none;"></button>
                          <div class="custom-close" data-bs-dismiss="modal" aria-label="Close"></div><img src="../../Generales/img/logo.png" alt="Logo" class="logoModal">
                        </div>
                        <div class="modal-body">
                            <div class="contexto">
                                ayuda y soporte...
                            </div>
                            <img src="../../generales/img/bingo.png" alt="Bolas que dicen bingo" class="Bingo">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cerrarSesion"></div>
                <button class="botonn bot-logout" id="logoutButton">
                    <img width="32" height="32" src="https://img.icons8.com/color-pixels/32/close-window.png" alt="close-window" />
                    <strong>Cerrar sesión</strong>
                </button>
            </div>

            <script src="../../Generales/musica/musica.js"></script>
            <script src="../../generales/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="config.js"></script>
</body>
</html>