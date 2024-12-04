let audio = new Audio('../../Generales/audio/apt.mp3');
audio.loop = true; // Repetir la música

// Verificar el estado de la música en localStorage
if (localStorage.getItem('musicPlaying') === 'true') {
    console.log('Reproduciendo música desde localStorage');
    audio.play(); // Reproducir música si estaba activa
} else {
    console.log('Música no estaba activa');
    localStorage.setItem('musicPlaying', 'false'); // Asegurarse de que esté apagada
}

// Función para alternar la reproducción
function toggleMusic() {
    const toggleButton = document.getElementById('soundToggle');
    
    if (audio.paused) {
        console.log('Reproduciendo música...');
        audio.play().then(() => {
            localStorage.setItem('musicPlaying', 'true'); // Guardar estado
            toggleButton.classList.add('active'); // Cambiar a estado activo
        }).catch(error => {
            console.error('Error al reproducir la música:', error);
        });
    } else {
        console.log('Pausando música...');
        audio.pause(); // Pausar la música
        localStorage.setItem('musicPlaying', 'false'); // Guardar estado
        toggleButton.classList.remove('active'); // Cambiar a estado inactivo
    }
}

// Asegúrate de que el botón de alternar música esté configurado correctamente
document.getElementById('soundToggle').addEventListener('click', toggleMusic);

// Agregar un evento para manejar el final de la música
audio.addEventListener('ended', function() {
    localStorage.setItem('musicPlaying', 'false'); // Asegurarse de que el estado se actualice
    console.log('La música ha terminado.');
});