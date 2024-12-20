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
$correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : 'Usuario';

?>



<!DOCTYPE html>
<html lang="en">12

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil</title>

 <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css">
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="../perfil/css/perfil.css" />
  <link rel="stylesheet" href="../perfil/css/modales.css">
  <link rel="stylesheet" href="../configuracion/posicion.css">
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
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
      <a href="../configuracion/configuracion.php" class="icon">
          <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>
      </div>
      <div id='monedas'></div>
      <script src="../Generales/monedas/js/conexion-monedas.js"></script>
    <script>
      cargarContenido();
  </script>
    


      <div class="editarimagen">

        <div class="editar edi-avatar" id="CambiarAvatar">
        </div>
        <div id="avatarvoid">
        <div id="avatarDisplay" class="avatarDisplay"></div>
          
          
        </div>
      </div>
      <div class="nombre-usuario"> 
        <div id="cambiarNombre" class="editar edi-nom"></div>
        <p class="nombre"><?php echo $nombre; ?> (ID: <?php echo $_SESSION['usuario_id']; ?>)</p>
      </div>
      <div class="contenedor-3">

        <div class="dino "></div>

        <div class="contenedor-gris">
          <div class="datos password text-light">
            <div class="editar fas fa-exclamation-circle" id="openModal2"></div>
            <p class="texto-contraseña">Contraseña:</p>
            <div class="usuario contraseña-usuario">********</div>
          </div>
          <div class="datos email text-light">
            <p class="texto-correo">Correo electronico:</p>
            <div class="usuario correo-usuario"><?php echo $correo; ?></div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="questionModal2" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">¿Seguro que quieres editar tu contraseña?</h5>
            </div>
            <div class="modal-body">
              <div class="d-flex justify-content-center">
                <button id="yesBtn2" class="botones-modal">Sí</button>
                <button id="noBtn2" class="botones-modal">No</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="navbar-container">
        <script src="../generales/barra_navegacion/navbar.js"></script>
        <script>
          loadNavbar();
        </script>
      </div>
    </div>

    <script src="../generales/musica/musica.js"></script>
    <script src="src-js/perfil.js"></script>
    <script src="src-js/modales.js"></script>
    <script src="../generales/monedas/js/obtener-monedas.js"></script>


</body>
</html>