<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicioSesion/InicioSesion.html');
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
    <title>Comprar Avatar</title>
    <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../Generales/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Generales/monedas/css/monedas-trofeos.css">
    <link rel="stylesheet" href="../perfil/css/comprarAvatar.css">
    <link rel="stylesheet" href="../Generales/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <script src="../Generales/bootstrap/js/bootstrap.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body class="container">
    <div id="contenedor">
        <div class="hojas">
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json" background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>
        <div class="hojas-2">
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json" background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>
        <div class="hojas-3">
            <dotlottie-player src="https://lottie.host/ad88f89d-a741-4835-959e-74fdca1d1c28/BT8qkiI0D1.json" background="transparent" speed="2" loop autoplay></dotlottie-player>
        </div>

        <div class="cuadro">

            <div id='monedas'></div>
            <script src="../Generales/monedas/js/conexion-monedas.js"></script>
          <script>
            cargarContenido();
        </script>
            <img id="redirigirPerfil" src="../Generales/img/cerrar.png" class="cerrar" alt="boton para cerrar esta ventana">
            <div class="ContenedorAvatar"></div>
            <div class="precio"></div>
            <div id="comprar" class="comprarAvatar">Comprar avatar</div>
        </div>
    </div>

    <!-- Audio player -->
    <audio id="audioPlayer">
        <source src="../Generales/musica/cant_hould_us.mp4" type="audio/mp4">
        Tu navegador no soporta la reproducción de audio.
    </audio>

    <script src="/Generales/musica/activar_y_desactivar_musica/musica.js"></script>
    <script src="./src-js/comprarAvatar.js"></script>

</body>
</html> 


