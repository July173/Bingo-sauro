window.audioPlayer = new Audio('https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3');
audioPlayer.loop = true; // Repetir la música

// Inicializar el estado del audio
let isPaused = true;

// Función para actualizar el estado del toggle
function actualizarToggle() {
    const soundToggle = document.getElementById('soundToggle');
    soundToggle.textContent = isPaused ? '🔇' : '🔊';
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
document.getElementById('soundToggle').addEventListener('click', toggleAudio);

// Al cargar la página, actualizar el estado del botón
window.addEventListener('load', actualizarToggle);

