document.getElementById('atras').addEventListener('click', function () {
    fetch('./php/salir_partida.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Mostrar mensaje de éxito
            window.location.href = "../home/inicio.php"; // Redirigir al inicio
        } else {
            alert(data.error); // Mostrar mensaje de error
        }
    })
    .catch(error => console.error('Error:', error));
});


function verificarUsuario() {
    fetch('./php/verificar-estadia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Si el usuario no está en la partida, redirigir a la pantalla de inicio
            alert(data.message); // Opcional: Mostrar mensaje
            window.location.href = "../home/inicio.php";
        }
        // Si sigue en la partida, no hacer nada
    })
    .catch(error => console.error('Error:', error));
}

// Ejecutar la verificación cada 5 segundos
setInterval(verificarUsuario, 5000);
