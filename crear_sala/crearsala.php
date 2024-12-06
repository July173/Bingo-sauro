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
  <link rel="stylesheet" href="css/crearsala.css">
  <link rel="stylesheet" href="../perfil/css/modales.css">
  <link rel="stylesheet" href="../generales/fontawesome/css/all.min.css">

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
    

      <div class="titulo"></div>
      <div class="logo"></div>


      <div class="contenedor-gris">
        <h6>Eres el creador de la sala </h6>

        <div class="comoLlenar">
          <p class="codigo ">codigo: </p>
          <!-- <p class="codigo ">codigo: </p> -->
          <div class="codigo " id="codigoPartida" name="codigoPartida"></div>
          <script>
            // Recuperar el código desde localStorage
            document.addEventListener("DOMContentLoaded", () => {
              const codigo = localStorage.getItem('codigoPartida');
              if (codigo) {
                document.getElementById('codigoPartida').textContent = codigo;
                console.log(codigo);
              } else {
                document.getElementById('codigoPartida').textContent = 'Código no disponible';
                console.log(codigo);
                console.log("no se llama el codigo");
              }
            });
            console.log(localStorage.getItem('codigoPartida'));
          </script>
        </div>

        <p class="comoLlenar">¿Cómo se llenara el carton?</p>
        <div class="contenedorDelContenedorDeCartonesSala">
          <div id="contenedorCartonesSala"></div>
        </div>

        <div class="cuadroGrisOscuro ">

          <div class="contenedorCantidadMaximaDeCartones">
            <p class="cantidadMaximaCartones">Ingresar la catidad maxima de cartones por jugador</p>
            <input type="number"  class="numCartonesPorJugador " placeholder="#">
            </input>
          </div>

          <div class="botonesEleccion">
            <button class="botonAdministrador">administrador</button>
          </div>

          <div class="contenedorCantidadMaximaDeMonedas">
            <p class="cantidadMaximaMonedas">Dino-monedas minimas que se deben apostar</p>
            <input type="number" class="numMonedasPorJugador" placeholder="#">
            </input>
          </div>
        </div>
        <div class="cuadrodeabajo">
          <h3>Jugadores</h3>
          <!-- Contenedor de jugadores -->
          <div id="lista-jugadores" class="jugadores">
    <!-- Aquí se agregarán los jugadores -->
          </div>
        </div>
<!-- 
        <div class="contenedorapostarjugador hidden">
          <p class="Ndinomontexto">¿Cuantas Dino-monedas apostaras?</p>
          <input type="number" class="numMonedas" placeholder="#" >
          </input>
        </div> -->

        <button class="iniciar">Iniciar partida</button>
      </div>

    </div>
  </div>



  <script src="js/codigo_partida.js"></script>
  <script src="js/crear_sala.js"></script>
  <script src="js/modal.js"></script>
  <script src="js/actualizar_jugadores.js"></script>
  <script src="js/validar-datos.js"></script>


  <script src="../generales/musica/musica.js"></script>
  <script src="../generales/monedas/js/obtener-monedas.js"></script>

</body>

</html>