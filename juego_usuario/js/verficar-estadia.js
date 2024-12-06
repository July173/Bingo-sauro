// Función para verificar si el usuario está en la partida
function verificarUsuario() {
    fetch('./php/verificar_estadia.php', {
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
        console.log("aun esta en la partida");
    })
    .catch(error => console.error('Error:', error));
}


// Ejecutar la verificación cada 5 segundos
setInterval(verificarUsuario, 5000);