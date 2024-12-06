// Función para verificar si el usuario está en la partida
function verificarUsuario() {
    fetch('./php/verificar-estadia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'verificarUsuario' }) // Se incluye una acción para distinguir la solicitud
    })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor.');
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                // Si el usuario no está en la partida, redirigir a la pantalla de inicio
                alert(data.message || 'Usuario no está en la partida.');
                window.location.href = "../home/inicio.php";
            }
        })
        .catch(error => {
            console.error('Error en la verificación del usuario:', error);
            alert('Error al verificar la participación en la partida.');
        });
}

// Ejecutar la verificación del usuario cada 5 segundos
setInterval(verificarUsuario, 5000);

// Función para verificar el estado de la partida
function verificarEstadoPartida() {
    const codigo = localStorage.getItem("codigoPartida");
    if (!codigo) {
        console.error('No se encontró el código de partida en LocalStorage.');
        alert('Código de partida no encontrado. Por favor, recarga la página.');
        return;
    }

    fetch(`./php/verificar-estadia.php?codigoPartida=${codigo}`, {
        method: 'GET',
    })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log(data.message);
                if (data.redirect) {
                    // Si la partida está iniciada, redirigir a la nueva página
                    window.location.href = '../juego_usuario/form-jugador.php';
                }
            } else {
                console.log(data.message || 'Estado de la partida no ha cambiado.');
            }
        })
        .catch(error => {
            console.error('Error al verificar el estado de la partida:', error);
            alert('Hubo un problema al verificar el estado de la partida.');
        });
}

// Ejecutar la verificación del estado de la partida cada 5 segundos
setInterval(verificarEstadoPartida, 5000);
