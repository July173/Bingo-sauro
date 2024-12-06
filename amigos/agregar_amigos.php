<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/inicio-sesion/inicio-sesion.html');
    exit();
}

$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Amigos</title>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../generales/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./css/agregar-amigos.css">
</head>
<body>
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
        <h1 class="text-center titulo-contenedor-agregar">Agregar Amigos</h1>
        <div class="card">
            <div class="card-header">
                Ingrese el ID del amigo
            </div>
            <div class="card-body">
                <form id="agregarAmigoForm">
                    <div class="form-group">
                        <label for="amigoId">ID del amigo:</label>
                        <input type="text" class="form-control" id="amigoId" placeholder="Ingresa el ID del amigo" required>
                    </div>
                    <button type="submit" class="btn btn-agregar">Agregar Amigo</button>
                </form>
                <div id="resultado" class="mt-3"></div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.getElementById('agregarAmigoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const amigoId = document.getElementById('amigoId').value;

            // Verificar que amigoId no esté vacío
            if (!amigoId) {
                alert('Por favor, ingresa un ID de amigo.');
                return;
            }

            console.log('ID del amigo:', amigoId);

            // Verificar si el ID del amigo existe en la base de datos
            fetch('./json/verificar_amigo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ amigo_id: amigoId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    // Si el amigo existe, proceder a agregarlo
                    agregarAmigo(amigoId);
                } else {
                    // Si no existe, mostrar un alert
                    alert('El ID del amigo que intentas agregar no existe en la base de datos.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function agregarAmigo(amigoId) {
            fetch('./json/agregar_amigo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ amigo_id: amigoId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirigir a la página de amigos
                    window.location.href = 'amigos.php'; // Cambia la ruta si es necesario
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

    <script src="../generales/musica/musica.js"></script>
</body>
</html>