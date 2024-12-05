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
    <title>Unirme Sala</title>
    <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../generales/configuracion/pocision2.css">
    <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
    <link rel="stylesheet" href="css/unirme.css">
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
                <a href="../home/inicio.php">
                    <img src="../generales/img/atras.png" alt="circulo-atras">
                </a>
            </div>


            <div class="logo"></div>


            <div class="contenedor-gris">


                <!-- Ingresar el código para unirse -->
                <div>
                    <input type="number" id="codigo" placeholder="Ingresa el código" class="codigo">
                    <button onclick="unirseAPartida()" class="iniciar" id="redirigirJuego">Unirse a Partida</button>
                </div>


            </div>


        </div>

    </div>
    </div>

    <script src="js/unirse_partida.js"></script>
    <script src="js/unirme.js"></script>
    <script src="../generales/musica/musica.js"></script>

</body>

</html>