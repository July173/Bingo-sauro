window.onload = function() {
    // Guardar la página anterior si no viene de un refresh
    if (document.referrer && !sessionStorage.getItem('previousPage')) {
        sessionStorage.setItem('previousPage', document.referrer);
    }

    // Asegurarse de que el audio esté pausado al inicio
    audioPlayer.pause();
    sessionStorage.setItem('audioPlaying', 'false'); // Guardar estado como apagado
    updateToggleButton(false); // Actualizar el estado del botón
};

document.querySelector('.close-btn').addEventListener('click', function() {
    const previousPage = sessionStorage.getItem('previousPage');
    if (previousPage) {
        window.location.href = previousPage;
    } else {
        history.back();
    }
});

document.getElementById('logoutButton').addEventListener('click', function () {
    fetch('php/cerrar-sesion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.logout) {
                // Eliminar cualquier dato almacenado localmente
                sessionStorage.clear();
                localStorage.clear();
                alert(data.mensaje);

                // Redirigir al usuario al inicio de sesión
                window.location.href = "./../../login/bienvenido/pag2.html";
            }
        })
        .catch((error) => {
            console.error('Error al cerrar sesión:', error);
        });
});

// Agregar este código para manejar el botón de retorno
document.addEventListener('DOMContentLoaded', function() {
    const botonRegresar = document.getElementById('botonRegresar');
    
    if (botonRegresar) {
        botonRegresar.onclick = function() {
            alert('¡Botón clickeado!');
            window.history.back();
        };
    } else {
        console.error('No se encontró el botón');
    }
});

// Obtener elementos del DOM
const audioPlayer = document.getElementById('audioPlayer');
const soundToggle = document.getElementById('soundToggle');

// Inicializar el estado del audio
let isPaused = true;

// Función para actualizar el estado del toggle
function actualizarToggle() {
    if (isPaused) {
        soundToggle.classList.add('off');
        soundToggle.textContent = '🔇'; // Cambiar a icono de silencio
    } else {
        soundToggle.classList.remove('off');
        soundToggle.textContent = '🔊'; // Cambiar a icono de sonido
    }
}

// Función para alternar el audio
function toggleAudio() {
    if (isPaused) {
        audioPlayer.play().catch(e => console.error("Error al reproducir audio:", e));
    } else {
        audioPlayer.pause();
    }
    isPaused = !isPaused; // Cambiar el estado
    actualizarToggle(); // Actualizar el botón
}

// Evento para el botón de sonido
soundToggle.addEventListener('click', toggleAudio);

// Al cargar la página, actualizar el estado del botón
window.addEventListener('load', actualizarToggle);
