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
$id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : '0';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>crearsala</title>
    <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../generales/configuracion/pocision2.css">
    <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
    <link rel="stylesheet" href="css/juego-usuario.css">
    <link rel="stylesheet" href="../perfil/css/modales.css">
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
          



            <div class="contenedor-gris">
                <h6>Tu eres un jugador </h6>
                <button class="bingo">Bingo</button>
                <div class="flex">
                <h1 style="text-align: center; background-color: white" class="tueres">Administrador:</h1>
                <p>Apostaste: dino-monedas</p>
                </div>
                <button onclick=>ver numeros salidos</button>
                <div id="contenedorCartones" class="contenedor-cartones"></div>


                <div class="cuadroAmigos"></div>
                
                <img src="" alt="">
                
            </div>
        </div>
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

        <script src="../generales/musica/musica.js"></script>
        <script src="js/juego-usuario.js"></script>
        <script src="../generales/monedas/js/obtener-monedas.js"></script>
        <script src="js/modal.js"></script>
        <script src="js/verficar-estadia.js"></script>
      <script>
         verificarUsuario()
      </script>
</body>

</html>