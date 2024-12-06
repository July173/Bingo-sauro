<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
    exit();
}

// Asignar el ID del usuario a la variable
$usuario_id = $_SESSION['usuario_id'];

// Conectar a la base de datos
require_once '../conexion_BD/conexion.php';
$conexion = new Conexion();

// Obtener la lista de amigos
$query = "SELECT u.id_usuario, u.primer_nombre, u.segundo_nombre, u.primer_apellido, u.segundo_apellido, u.contador_trofeos 
          FROM amigo a 
          JOIN usuario u ON a.amigo_id = u.id_usuario 
          WHERE a.usuario_id = :usuario_id";
$amigos = $conexion->select($query, ['usuario_id' => $usuario_id]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Amigos</title>

  <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../generales/barra_navegacion/navbar.css" />
  <link rel="stylesheet" href="../generales/monedas/css/monedas-trofeos.css">
  <link rel="stylesheet" href="../amigos/css/amigos.css" />
  <link rel="stylesheet" href="../amigos/css/modales.css">
  <link rel="stylesheet" href="../generales/configuracion/posicion.css">
  <script src="../generales/bootstrap/js/bootstrap.js"></script>
  <script src="../generales/bootstrap/js/bootstrap.bundle.js"></script>
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
        <!-- Botón de Configuración (Engranaje) -->
        <a href="../configuracion/configuracion.php" class="icon">
          <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/settings.png" alt="settings" />
        </a>
      </div>
      <div id='monedas'></div>
      <script src="../generales/monedas/js/conexion-monedas.js"></script>
      <script>
        cargarContenido();
      </script>
      <div class="logo"></div>

      <a href="agregar_amigos.php" class="btn btn-success invitarAmigo">Invitar un amigo</a>
      <div class="contenedor-3">
        <div class="dino"></div>
        <div class="contenedor-gris">
          <div class="texto-contenedor">
            <div class="titulo-contenedor">Amigos</div>
            <p class="text-trofeo text-secondary">Dino-trofeos</p>
          </div>
          <br>
          <div class="list-group"></div>
    <?php if (count($amigos) > 0): ?>
        <?php foreach ($amigos as $amigo): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center dinoTrofeosLinea" 
                 data-id="<?php echo $amigo['id_usuario']; ?>" 
                 onclick="confirmarEliminacion(this)">
                <?php echo htmlspecialchars($amigo['primer_nombre'] . ' ' . $amigo['primer_apellido']); ?>
                <span class="badge dinotrofeos"><?php echo htmlspecialchars($amigo['contador_trofeos']); ?><img src="../generales/img/dinoTrofeos.png" alt="trofeos amigos" class="trofeos-amigos"></span>
                <button class="btn btn-success btn-x" onclick="event.stopPropagation(); confirmarEliminacion(this.parentElement)">Eliminar</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="list-group-item sin">No tienes amigos agregados.</div>
    <?php endif; ?>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar a este amigo?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmarEliminar">Eliminar</button>
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
      </div>

    <script src="../generales/musica/musica.js"></script>
    <script src="../generales/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <script src="src-js/amigos.js"></script>
    <script src="../generales/monedas/js/obtener-monedas.js"></script>

</body>
</html>