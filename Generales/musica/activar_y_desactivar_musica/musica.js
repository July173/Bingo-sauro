// Obtener elementos del DOM
const audio = new Audio('ruta/a/tu/cancion.mp3');
const soundToggle = document.getElementById('soundToggle');

// Función para actualizar el estado del toggle
function actualizarToggle(estaPausado) {
    if (estaPausado) {
        soundToggle.classList.add('off');
    } else {
        soundToggle.classList.remove('off');
    }
}

// Al cargar la página
window.addEventListener('load', function() {
    const tiempoGuardado = localStorage.getItem('audioTime');
    const estaPausado = localStorage.getItem('isPaused') === 'true';

    if (tiempoGuardado) {
        audio.currentTime = parseFloat(tiempoGuardado);
    }

    actualizarToggle(estaPausado);

    if (!estaPausado) {
        audio.play().catch(e => console.error("Error al reproducir audio:", e));
    }
});

// Guardar el tiempo actual del audio periódicamente y al salir de la página
setInterval(() => {
    localStorage.setItem('audioTime', audio.currentTime);
}, 1000);

window.addEventListener('beforeunload', function() {
    localStorage.setItem('audioTime', audio.currentTime);
});

// Alternar entre pausar y reproducir el audio al hacer clic en el toggle
soundToggle.addEventListener('click', function() {
    const estaPausado = audio.paused;
    
    if (estaPausado) {
        audio.play().catch(e => console.error("Error al reproducir audio:", e));
        localStorage.setItem('isPaused', 'false');
    } else {
        audio.pause();
        localStorage.setItem('isPaused', 'true');
    }

    actualizarToggle(!estaPausado);
});

// Exponer funciones para controlar el audio desde otras partes de la aplicación
window.musicaControl = {
    play: () => {
        audio.play().catch(e => console.error("Error al reproducir audio:", e));
        localStorage.setItem('isPaused', 'false');
        actualizarToggle(false);
    },
    pause: () => {
        audio.pause();
        localStorage.setItem('isPaused', 'true');
        actualizarToggle(true);
    },
    toggleMute: () => {
        audio.muted = !audio.muted;
        actualizarToggle(audio.muted);
    }
};
