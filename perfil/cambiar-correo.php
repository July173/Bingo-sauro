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
  <title>Editar correo de usuario </title>
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
  <link rel="stylesheet" href="../perfil/css/cambiar-correo.css" />
  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="-./generales/fontawesome/css/all.min.css">
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
      <div class="titulo">Editar correo electronico</div>
      <img id="redirigirPerfil" src="../Generales/img/cerrar.png" class="cerrar" alt="boton para cerrar esta pantalla">
      <div id="ocultar" class="logo"></div>

      <div id="error-animation" style="display: none;">
        <dotlottie-player src="https://lottie.host/1a766c67-0f84-4893-bc7d-5a194e550e6f/swmFcahnNg.json"
          background="transparent" speed="1" style="width: 150px; height: 150px;" loop autoplay>
        </dotlottie-player>
      </div>

      <form id="formCambiarCorreo" class="needs-validation" novalidate>
        <label for="nuevo_correo" class="email fw-bold form-label">Nuevo correo electrónico</label>
        <div class="has-validation input-container">
            <img class="i" width="30" height="30" src="https://img.icons8.com/ios/50/letter-with-email-sign.png"
                alt="letter-with-email-sign" />
            <input type="email" class="input form-control" id="nuevo_correo" 
                placeholder="pepito@gmail.com" required>
            <div class="invalid-tooltip">
                Por favor digita un correo electrónico válido.
            </div>
        </div>

        <label for="confirmar_correo" class="email fw-bold form-label">Confirmar correo electrónico</label>
        <div class="has-validation input-container">
            <img class="i" width="30" height="30" src="https://img.icons8.com/ios/50/letter-with-email-sign.png"
                alt="letter-with-email-sign" />
            <input type="email" class="input form-control" id="confirmar_correo" 
                placeholder="pepito@gmail.com" required>
            <div class="invalid-tooltip">
                Los correos electrónicos deben coincidir.
            </div>
        </div>

        <button class="enviar" type="submit">Cambiar</button>
      </form>

      <script src="../generales/musica/musica.js"></script>
      <script src="./src-js/cambiar-correo.js"></script>
</body>

</html>