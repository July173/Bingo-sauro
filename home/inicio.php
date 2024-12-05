<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
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
  <link rel="stylesheet" href="../generales/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css"> 
  <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css">
  <link rel="stylesheet" href="../home/css/inicio.css" />
  <link rel="stylesheet" href="../generales/loader/loder.css">
  <script src="../generales/barra_navegacion/navbar.js"></script>
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

      <!-- <div id="contenido-cargado"></div> -->

      <div class="icon-container">
        <!-- Botón de Configuración (Engranaje) -->
        <a href="../generales/configuracion/configuracion.php" class="icon">
          <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>

        <!-- Botón de Ayuda (Signo de pregunta) -->

        <!-- Botón para abrir el modal de Pregunta -->
     
          <a href="como-jugar.php" class="icon"> <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/ask-question.png"
          alt="ask-question" /></a>
         
        
        <!-- Botón RG -->
        <a href="rd.php" class="icon">
          <span style="font-size: 24px;">R<sup>D</sup></span>
        </a>
      </div>
      <div id='monedas'></div>
      <script src="../generales/monedas/js/conexion-monedas.js"></script>
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
 

    <script src="../generales/musica/musica.js"></script>
    <script src="../generales/bootstrap/js/bootstrap.js"></script>
    <script src="../crear_sala/js/crear_sala.js"></script>
    <script src="../crear_sala/js/codigo_partida.js"></script>
    <script src="../generales/monedas/js/obtener-monedas.js"></script>
    <script src="src-js/inicio.js"></script>

</html>