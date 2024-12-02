<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
}

// Opcional: Obtener información del usuario para mostrar en la página
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial</title>

  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css">
  <link rel="stylesheet" href="../generales/configuracion/posicion.css">
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="../historial/css/historial.css">
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
  <link rel="stylesheet" href="../generales/fontawesome/css/all.css">
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

        <!-- Botón de Configuración (Engranaje) -->
         <div class="icon-container">
         <a href="../generales/configuracion/configuracion.php" class="icon">
         <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>
      </div>
      <div id='monedas'></div>
        <script src="../generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
    </script>

      <div class="logo"></div>
      <div class="contenedor-gris">
        <div class="titulo-contenedor">Partidas jugadas</div>
        <div class="subtitulos">
          <p class="sub"> Fecha </p>
          <p class="sub">Carton</p>
          <p class="sub ">G o P</p>
        </div>

        <div id="historialJugar" class="nada"></div>
      </div>

      <div id='navbar-container'></div>
      <script src="../generales/barra_navegacion/navbar.js"></script>
      <script>
        loadNavbar();

      </script>
    </div>

    <!-- Audio que queremos controlar -->
    <audio id="audioPlayer">
      <source src="../generales/musica/dinoMusica.mp3" type="audio/mp3">
      Tu navegador no soporta la reproducción de audio.
    </audio>

    <script src="../generales/musica/activar_y_desactivar_musica/musica.js"></script>
    <script src="src-js/historial.js"></script>
    <script src="../generales/monedas/js/obtener-monedas.js"></script>

</body>

</html>