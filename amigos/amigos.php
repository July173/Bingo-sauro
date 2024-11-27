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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Amigos</title>

  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css" />
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="../amigos/css/amigos.css" />
  <link rel="stylesheet" href="../amigos/css/modales-delete.css">
  <link rel="stylesheet" href="../generales/configuracion/posicion.css">
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
  <script src="../generales/bootstrap/js/bootstrap.bundle.js"></script>
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
        <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>
      </div>
      <div id='monedas'></div>
      <script src="../generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
      </script>
      <div class="logo"></div>

      <button class="invitarAmigo">Invitar un amigo</button>
      <div class="contenedor-3">
        <div class="dino"></div>
        <div class="contenedor-gris">
          <div class="texto-contenedor">
            <div class="titulo-contenedor">Amigos</div>
            <p class="text-trofeo text-secondary">Dino-trofeos</p>
          </div>
          <div id="AmigosRegistro"></div>
        </div>
      </div>

      <div id="navbar-container">
        <script src="../generales/barra_navegacion/navbar.js"></script>
        <script>
          loadNavbar();
        </script>
      </div>
    </div>

    <audio id="audioPlayer" loop>
      <source src="../generales/musica/dinoMusica.mp3" type="audio/mp3">
      Tu navegador no soporta la reproducción de audio.
    </audio>

<!-- Modal que se abre al hacer clic en un amigo -->
<div class="modal fade" id="questionModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center">
          <button id="elimi" class="botones-modal" data-bs-target="#confirmModal" data-bs-toggle="modal">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar a este amigo?</p>
        <button class="botones-modal" id="confirmarEliminacion">Sí</button>
        <button class="botones-modal" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
    <script src="src-js/amigos.js"></script>
    <script src="../generales/musica/activar_y_desactivar_musica/musica.js"></script>
</body>
</html>