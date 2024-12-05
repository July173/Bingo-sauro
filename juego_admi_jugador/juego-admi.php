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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>crearsala</title>
  <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../Generales/configuracion/pocision2.css">
  <link rel="stylesheet" href="../Generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="css/juegoAdmi.css">
  <script src="../Generales/bootstrap/js/bootstrap.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
</head>

<body class="container">

  <div id="contenedor">

    <div class="hojas">
      <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
        type="module"></script>
      <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
        background="transparent" speed="1" loop autoplay></dotlottie-player>
    </div>


    <div class="hojas-2">
      <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
        type="module"></script>
      <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
        background="transparent" speed="1" loop autoplay></dotlottie-player>
    </div>

    <div class="hojas-3">
      <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
        type="module"></script>
      <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
        background="transparent" speed="1" loop autoplay></dotlottie-player>
    </div>
    <div class="cuadro">

      <div id='monedas'></div>
      <script src="../Generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
      </script>

      <div class="atras">
        <a href="/Bingo-sauro/home/inicio.html">
          <img src="../Generales/img/atras.png" alt="circulo-atras">
        </a>
      </div>



      <div class="contenedor-gris">
        <div class="texto">
        <h6>Tu eres el administrador </h6>
        <h4 class="nMaxCartones" id="cartonesMaximos">Cantidad maxima de cartones:</h4>
      </div>
      <div class="">
        <button>Ver numeros mostrados </button>
      <p>Minimo de dino-monedas para apostar:</p>

      </div>
        <div class="">
          <div class="amigos"></div>
          <p></p>
        </div>
        <div class="ruleta">
        <div class="balotera">
          <img src="../Generales/img/boleteraQuieta.png" alt="balotera del bingo">
        </div>
        <button class="girar">Girar bombo</button>
      </div>
      </div>

      <!-- Audio que queremos controlar -->
      <audio id="audioPlayer" loop>
        <source src="../Generales/musica/dinoMusica.mp3" type="audio/mp3">
        Tu navegador no soporta la reproducción de audio.
      </audio>

  <script src="../Generales/musica/activar_y_desactivar_musica/musica.js"></script>
  <script src="../generales/monedas/js/obtener-monedas.js"></script>

</body>

</html>