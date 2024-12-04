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
    <title>Redes Sociales</title>
    <link href="../generales/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../home/css/rd.css">
</head>

<body>
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

        <div class="boton">
            <img class="close-btn" onclick="location='../home/inicio.php'" width="48" height="48"
                src="../generales/img/cerrar.png" alt="cross-mark-button-emoji" />
        </div>

        <h2 class="letra"><b>Nuestras redes sociales</b></h2>
        <img src="../generales/img/logo.png" alt="Bingo Dinosaur" class="img-fluid my-3 mascot" width="200">
        <h3 class="letra-contac"><b>Contáctenos</b></h3>
        <img src="../Generales/img/dinosaurio-cute.png" alt="Dino" class="dino-image">
        <div class="d-flex justify-content-center align-items-center">
            <div class="ms-3 iconos">
                <a href="https://www.facebook.com/profile.php?id=61564398793159&mibextid=ZbWKwL"><img
                        src="../Generales/img/facebook.png" alt="Facebook" class="social-icon"></a>
                <a href="#"><img src="../Generales/img/email.png" alt="Email" class="social-icon"></a>
                <a href="https://www.instagram.com/bingosauriooficial?igsh=MTgxdTF2eHFlYWZsOQ=="><img
                        src="../Generales/img/insta (1).png" alt="Instagram" class="social-icon"></a>
            </div>
        </div>
    </div>

    <audio id="audioPlayer" loop>
        <source src="../generales/musica/dinoMusica.mp3" type="audio/mp3">
        Tu navegador no soporta la reproducción de audio.
    </audio>

    <script src="../generales/musica/musica.js"></script>
    <script src="../generales/bootstrap/js/bootstrap.js"></script>
</body>

</html>