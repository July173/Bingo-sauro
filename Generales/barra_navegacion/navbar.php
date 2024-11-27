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


  <table class="tabla">
    <tr class="fila">
      <td class="Columna" id="inicio">INICIO</td>
      <td class="Columna" id="historial">HISTORIAL</td>
      <td class="Columna" id="amigos">AMIGOS</td>
      <td class="Columna" id="perfil">PERFIL</td>
      <td class="Columna cinco" id="tienda">TIENDA</td>
    </tr>
  </table>
