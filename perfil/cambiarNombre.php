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
  <title>Cambiar nombre de usuario </title>
  <script src="../Generales/bootstrap/js/bootstrap.js"></script>
  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
  <link rel="stylesheet" href="../perfil/css/cambiarNombre.css" />
  <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../Generales/fontawesome/css/all.min.css">
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
      <div class="titulo">Editar nombre de usuario</div>
      <img id="redirigirPerfil" src="../Generales/img/cerrar.png" class="cerrar" alt="boton para cerrar esta pantalla">
      <div id="ocultar" class="logo"></div>

      <div id="error-animation" style="display: none;">
        <dotlottie-player src="https://lottie.host/1a766c67-0f84-4893-bc7d-5a194e550e6f/swmFcahnNg.json"
          background="transparent" speed="1" style="width: 150px; height: 150px;" loop autoplay>
        </dotlottie-player>
      </div>

      <form action="procesar_cambio_nombre.php" method="POST" class="needs-validation" novalidate>

        <label for="nuevo_nombre" class="Name fw-bold form-label">Nombre de usuario nuevo</label>
        <div class="input-container">
          <img class="i" width="30" height="30" src="https://img.icons8.com/material-sharp/24/user-male-circle.png"
            alt="user-male-circle" />
          <input type="text" class="input form-control" id="nuevo_nombre" name="nuevo_nombre" required minlength="5"
            placeholder="Pepito">
          <div class="invalid-tooltip">
            El nombre de usuario debe tener al menos 5 caracteres y no ser ofensivo.
           </div>
        </div>

        <label for="confirmar_nombre" class="Name fw-bold form-label">Confirmar nuevo nombre</label>
        <div class="input-container">
          <img class="i" width="30" height="30" src="https://img.icons8.com/material-sharp/24/user-male-circle.png"
            alt="user-male-circle" />
          <input type="text" class="input form-control" id="confirmar_nombre" name="confirmar_nombre" required minlength="5"
            placeholder="Pepito">
          <div class="invalid-tooltip">
            El nombre de usuario debe tener al menos 5 caracteres y no ser ofensivo.
           </div>
        </div>

            <!-- Audio que queremos controlar -->
            <audio id="audioPlayer">
              <source src="/Generales/musica/dinoMusica.mp3" type="audio/mp3">
              Tu navegador no soporta la reproducción de audio.
            </audio>

            <button id="redirigirIniciar" class="enviar" type="submit">Cambiar</button>

      </form>

      <script src="/Generales/musica/activar_y_desactivar_musica/musica.js"></script>
      <script src="./src-js/cambiarNombre.js"></script>
</body>

</html>