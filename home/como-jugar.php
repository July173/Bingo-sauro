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
    <title>Ayuda</title>
    <link href="../generales/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/como-jugar.css">
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

        <h2 class="letra"><b>Como juagar</b></h2>
        <img src="../generales/img/logo.png" alt="Bingo Dinosaur" class="img-fluid my-3 mascot" width="100">
        <div class="cuadro-blanco">
          
            jsjsjs
          
        </div>
        <img src="../generales/img/bingo.png" class="bingo" alt="Bolas que dicen bingo">

    </div>

   
    <script src="../generales/musica/musica.js"></script>
    <script src="../generales/bootstrap/js/bootstrap.js"></script>
</body>

</html>