// Función para verificar si el usuario está en la partida
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

// Función para verificar el estado de la partida
function verificarEstadoPartida() {
    fetch('./php/verificar-estadia.php')  // Aquí debes colocar la ruta correcta del PHP
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data.message);
                if (data.redirect) {
                    // Si la partida está iniciada, redirigir a la nueva página
                    window.location.href = '../juego_usuario/form-jugador.php';  // Aquí coloca la URL de la página a la que quieres redirigir
                }
            } else {
                console.log(data.message); // Mostrar mensaje si no está iniciada
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al verificar el estado de la partida.');
        });
}

// Ejecutar la función cada 5000ms (5 segundos)
setInterval(verificarEstadoPartida, 5000);
