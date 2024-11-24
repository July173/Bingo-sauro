<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicioSesion/InicioSesion.html');
    exit();
}

// Opcional: Obtener información del usuario para mostrar en la página
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="../Generales/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../Generales/monedas/css/monedas-trofeos.css"> 
  <link rel="stylesheet" href="../Generales/barraNavegacion/navbar.css">
  <link rel="stylesheet" href="../home/css/inicio.css" />
  <link rel="stylesheet" href="../Generales/loader/loder.css">
  <script src="../Generales/barraNavegacion/navbar.js"></script>
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

    <div id="loader" style="display: none;">
    <!-- Aquí va el diseño del loader -->
    <div class="spinner"></div>
    <p>Cargando...</p>
</div>

    <div class="cuadro">

      <!-- <div id="contenido-cargado"></div> -->

      <div class="icon-container">
        <!-- Botón de Configuración (Engranaje) -->
        <a href="http://localhost/Bingo-sauro/Generales/configuracion/configuracion.php" class="icon">
          <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>

        <!-- Botón de Ayuda (Signo de pregunta) -->

        <!-- Botón para abrir el modal de Pregunta -->
        <div class="icon" data-bs-toggle="modal" data-bs-target="#modalPregunta">
          <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/ask-question.png"
            alt="ask-question" />
        </div>
        <!-- Botón RG -->
        <a href="http://localhost/Bingo-sauro/home/rd.php" class="icon">
          <span style="font-size: 24px;">R<sup>D</sup></span>
        </a>
      </div>
      <div id='monedas'></div>
      <script src="../Generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
      </script>
      <div class="titulo">BIENVENIDOS</div>

      <div class="logo"></div>

 
        <button class=" enviar Crearsala" id="miBotonn">Crear sala</button>
  

      <button class="enviar unirme" id="unirme">Unirme</button>

      <div id='navbar-container'></div>
      <script>
        loadNavbar();
      </script>
    </div>
    <!-- Modal
    <div class="modal fade" id="modalPregunta" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="modalPreguntaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable ">
        <div class="modal-content  bg-transparent">
          <div class="modal-header">
            <h1 class="modal-title fs-3 title-modal" id="modalPreguntaLabel">Términos y condiciones</h1>
            <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"
              style="display:none;"></button>
            <div class="close-custom" data-bs-dismiss="modal" aria-label="Close"></div>
            <img src="/Generales/img/logo.png" alt="Logo" class="inicioLogo">
          </div>

          <div class="modal-body">
            <div class="context">
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...
              El juego Bingo-Saurio está creado con fines de entretenimiento...

            </div>
            <img src="/Generales/img/bingo.png" alt="Bolas que dicen bingo" class="BingoImg">
          </div>
        </div>
      </div> -->


    <!-- Audio que queremos controlar -->
    <audio id="audioPlayer" loop>
      <source src="../Generales/musica/dinoMusica.mp3" type="audio/mp3">
      Tu navegador no soporta la reproducción de audio.
    </audio>

    <script src="../Generales/bootstrap/js/bootstrap.js"></script>
    <script src="../Crearsala/js/CodigoPartida.js"></script>
    <script src="../Generales/musica/activar_y_desactivar_musica/musica.js"></script>
    <script src="../Generales/loader/loader.js"></script>
    <script src="src-js/inicio.js"></script>


</html>
