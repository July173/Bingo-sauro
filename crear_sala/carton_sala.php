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
  <title>Comprar carton</title>

  <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../Generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="css/comprarCarton.css">
  <script src="../Generales/bootstrap/js/bootstrap.js"></script>
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


      <div id='monedas'></div>
      <script src="../Generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
      </script>

      <a href="/Bingo-sauro/Crearsala/crearsala.php">
        <img src="../Generales/img/cerrar.png" alt="cierre" class="cerrar">
      </a>

      <div class="contenedorCartonSeleccionado"></div>
      <div class="precio"></div>
      <div id="comprar" class="comprarAvatar">Comprar carton</div>



    </div>

    <!-- Audio que queremos controlar -->
    <audio id="audioPlayer">
      <source src="/Generales/musica/dinoMusica.mp3" type="audio/mp3">
      Tu navegador no soporta la reproducción de audio.
    </audio>

    
    <script src="../Generales/musica/activar_y_desactivar_musica/musica.js"></script>
    <script src="../Crearsala/js/compraCartonSala.js"></script>
</body>

</html>