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
  <title>Juego administrador</title>
  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../generales/configuracion/pocision2.css">
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="../perfil/css/modales.css">
  <link rel="stylesheet" href="css/juego-admi.css">
  <script src="../generales/bootstrap/js/bootstrap.js"></script>

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
          <img src="../generales/img/atras.png" alt="circulo-atras" id="openModal">
      </div>

      <div class="icon" data-bs-toggle="modal" data-bs-target="#modalPregunta">
        <img width="
        40" height="40" src="https://img.icons8.com/material-sharp/24/ask-question.png" alt="ask-question" />
      </div>
<!-- Modal de salida  -->
    <div class="modal fade" id="questionModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-sm">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres salir de la partida?</h5>
           </div>
           <div class="modal-body">
             <div class="d-flex justify-content-center">
               <button id="yesBtn" class="botones-modal">Sí</button>
               <button id="noBtn" class="botones-modal">No</button>
             </div>
           </div>
         </div>
       </div>
     </div>
<!-- Modal bolas  -->
<div class="modal fade" id="questionModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-sm">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres salir de la partida?</h5>
           </div>
           <div class="modal-body">
             <div class="d-flex justify-content-center">
               <button id="yesBtn" class="botones-modal">Sí</button>
               <button id="noBtn" class="botones-modal">No</button>
             </div>
           </div>
         </div>
       </div>
     </div>


      <div class="contenedor-gris">
        <div class="texto">
          <h6>Tu eres el administrador </h6>
          <h4 class="nMaxCartones" id="cartonesMaximos">Cantidad maxima de cartones:</h4>
        </div>
        <div class="">
          <button class="verNumeeros">Ver numeros mostrados </button>
          <p id="minimoMonedas">Minimo de dino-monedas para apostar:</p>

        </div>
        <div class="flex">

          <div class="cuadrodeabajo">
            <h3>Jugadores</h3>
            <!-- Contenedor de jugadores -->
            <div id="lista-jugadores" class="jugadores">
              <!-- Aquí se agregarán los jugadores -->
            </div>
          </div>
          <div class="ruleta">
          <div class="balotera">
                 <img id="baloteraImg" src="../Generales/img/boleteraQuieta.png" alt="balotera del bingo">
          </div>
          </div>
        </div>
        <button class="girar" onclick="girarBombo()">Girar bombo</button>        <p>Por se administrador obtendras 7 dino-monedas</p>
        <div id="bola-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;">
      <img id="bola-img" src="" alt="Bola de Bingo" style="max-width: 90%; max-height: 90%; cursor: pointer;">
      </div>

        <!-- Audio que queremos controlar -->
        <audio id="audioPlayer" loop>
          <source src="../Generales/musica/dinoMusica.mp3" type="audio/mp3">
          Tu navegador no soporta la reproducción de audio.
        </audio>

        <script src="../Generales/musica/activar_y_desactivar_musica/musica.js"></script>
        <script src="../generales/monedas/js/obtener-monedas.js"></script>
        <!-- <script src="js/movimiento-balotera.js"></script> -->
        <script src="js/modal.js"></script>
        <script src="js/obtener_bola.js"></script>
        <script src="js/juego_admi.js"></script>

</body>

</html>