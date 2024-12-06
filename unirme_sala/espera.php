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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espera</title>
  <link rel="stylesheet" href="css/espera.css">
  <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />

</head>
<body>
<div class="atras" id="atras">
          <img src="../generales/img/atras.png" alt="circulo-atras" id="openModal" ">
        
      </div>
  <div class="loader-dino">


  <div class="dino">
  <script
        
          src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
          type="module"
        ></script>
        <dotlottie-player
          src="https://lottie.host/82dcafe9-9788-467d-86b6-ed1c9388f6b6/l19K6Qr2X3.json"
          background="transparent"
          speed="1"
          style="width: 8rem; height: 8rem"
          loop
          autoplay
        ></dotlottie-player>
        </div>
          <div class="ground"></div>
          <div class="texto">  Hola <?php echo $nombre; ?>, Espera que el administrador inicie la partida </div>

  </div>
  
  <div class="clouds">
    <div class="cloud"></div>
    <div class="cloud"></div>
    <div class="cloud"></div>
    <div class="cloud"></div>

  </div>
  
  <script src="../generales/musica/musica.js"></script>
  <script src="js/espera.js"></script>
  <script>
    setInterval(verificarUsuario, 5000);
</script>   
</body>
</html>
