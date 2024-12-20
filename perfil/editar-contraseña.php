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
  <title>Cambiar contraseña</title>
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
  <link rel="stylesheet" href="../perfil/css/editar-contra.css" />
  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/fontawesome/css/all.min.css">
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
      <div class="titulo">Editar constraseña</div>
      <img id="redirigirCodigo" src="../generales/img/cerrar.png" class="cerrar" alt="boton para cerrar esta pantalla">
      <div id="ocultar" class="logo"></div>

      <div id="error-animation" style="display: none;">
        <dotlottie-player src="https://lottie.host/1a766c67-0f84-4893-bc7d-5a194e550e6f/swmFcahnNg.json"
          background="transparent" speed="1" style="width: 150px; height: 150px;" loop autoplay>
        </dotlottie-player>
      </div>

      <form id="formCambiarContraseña" class="needs-validation" novalidate>
        <label for="password_actual" class="password fw-bold form-label">Contraseña actual</label>
        <div class="input-container position-relative">
            <img class="i candadoUno" width="30" height="30" src="https://img.icons8.com/ios-filled/50/lock.png" alt="lock" />
            <input type="password" class="input fs-5 form-control" id="password_actual" required minlength="8" placeholder="********">
            <i class="fa-solid fa-eye-slash toggle-password" data-target="password_actual"
                style="position: absolute; right: 35px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            <div class="invalid-tooltip">
                Ingresa tu contraseña actual.
            </div>
        </div>

        <label for="password_nuevo" class="password fw-bold form-label">Nueva contraseña</label>
        <div class="input-container position-relative">
            <img class="i" width="30" height="30" src="https://img.icons8.com/ios-filled/50/lock.png" alt="lock" />
            <input type="password" class="input fs-5 form-control" id="password_nuevo" required minlength="8" placeholder="********">
            <i class="fa-solid fa-eye-slash toggle-password" data-target="password_nuevo"
                style="position: absolute; right: 35px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            <div class="invalid-tooltip">
                La contraseña debe tener al menos 8 caracteres y contener al menos un número.
            </div>
        </div>

        <label for="password_confirmar" class="password fw-bold form-label">Confirmar nueva contraseña</label>
        <div class="input-container position-relative">
            <img class="i" width="30" height="30" src="https://img.icons8.com/ios-filled/50/lock.png" alt="lock" />
            <input type="password" class="input fs-5 form-control" id="password_confirmar" required minlength="8" placeholder="********">
            <i class="fa-solid fa-eye-slash toggle-password" data-target="password_confirmar"
                style="position: absolute; right: 35px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            <div class="invalid-tooltip">
                Las contraseñas deben coincidir.
            </div>
        </div>

        <button class="enviar" type="submit">Cambiar</button>
      </form>

      <script src="../generales/js_generales/ver-contrasña.js"></script>
      <script src="src-js/editar-contra.js"></script>
      <script src="../generales/musica/musica.js"></script>

      <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-body text-center">
                      <div class="animation-container">
                          <dotlottie-player 
                              src="https://lottie.host/2d74af69-d3ab-4883-9908-4d6cc7e1f76b/UKWnAuZhgr.json"
                              background="transparent" 
                              speed="1" 
                              style="width: 150px; height: 150px;" 
                              loop="false" 
                              autoplay>
                          </dotlottie-player>
                      </div>
                      <h4 class="mt-3">¡Contraseña actualizada correctamente!</h4>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</body>

</html>