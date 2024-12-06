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
    <title>Form</title>
    <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../generales/configuracion/pocision2.css">
    <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
    <link rel="stylesheet" href="../perfil/css/modales.css">
    <link rel="stylesheet" href="./css/fomr.css">
    <script src="../generales/bootstrap/js/bootstrap.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
</head>

<body class="container">

    <div id="contenedor">

        <div class="hojas">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
        </div>


        <div class="hojas-2">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
        </div>

        <div class="hojas-3">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                type="module"></script>
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json"
                background="transparent" speed="1" loop autoplay></dotlottie-player>
        </div>
        <div class="cuadro">

            <div id='monedas'></div>
            <script src="../generales/monedas/js/conexion-monedas.js"></script>
            <script>
                cargarContenido();
            </script>

            <div class="atras">
          <img src="../generales/img/atras.png" alt="circulo-atras" id="openModal">
      </div>


            <div class="logo"></div>


            <div class="contenedor-gris">


                <div>
                    <p>Ingresa la cantidad de monedas que vas a apostar </p>
                    <input type="number" id="monedas" placeholder="Ingresa" class="codigo">
                </div>
                   <div>
                   <p>Ingresa la cantidad de cartones que quieres jugar </p>
                    <input type="number" id="cartones" placeholder="Ingresa " class="codigo">
                    <button class="iniciar" id="redirigirJuego">Entrar</button>
                </div>


            </div>


        </div>

    </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="questionModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-sm">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres salir de la partida?</h5>
           </div>
           <div class="modal-body">
             <div class="d-flex justify-content-center">
               <button id="yesBtn" class="botones-modal">Sí</button>
               <button id="noBtn" class="botones-modal">No</button>
             </div>
           </div>
         </div>
       </div>
     </div>
    <script src="js/form.js"></script>
    <script src="../generales/monedas/js/obtener-monedas.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/verficar-estadia.js"></script>

</body>

</html>