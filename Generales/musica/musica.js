let audio = new Audio('../generales/musica/bingo-musica.mp3');
audio.loop = true; // Repetir la música

// Verificar el estado de la música en localStorage
if (localStorage.getItem('musicPlaying') === 'true') {
    console.log('Reproduciendo música desde localStorage');
    audio.currentTime = localStorage.getItem('musicPosition') || 0; // Establecer la posición
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
            if (toggleButton) {
                toggleButton.classList.add('active'); // Cambiar a estado activo
            }
        }).catch(error => {
            console.error('Error al reproducir la música:', error);
        });
    } else {
        console.log('Pausando música...');
        audio.pause(); // Pausar la música
        localStorage.setItem('musicPlaying', 'false'); // Guardar estado
        if (toggleButton) {
            toggleButton.classList.remove('active'); // Cambiar a estado inactivo
        }
    }
}

// Guardar la posición de la música en localStorage al pausar
audio.addEventListener('pause', function() {
    console.log('Guardando posición:', audio.currentTime); // Verifica la posición guardada
    localStorage.setItem('musicPosition', audio.currentTime); // Guardar la posición actual
});

// Reproducir música al cargar la página
window.addEventListener('load', function() {
    if (localStorage.getItem('musicPlaying') === 'true') {
        audio.play().then(() => {
            console.log('Música iniciada desde localStorage');
        }).catch(error => {
            console.error('Error al reproducir la música:', error);
        });
    }

    // Asegúrate de que el botón de alternar música esté configurado correctamente
    const toggleButton = document.getElementById('soundToggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleMusic);
    }
});

// Limpiar el almacenamiento local al cerrar sesión o cuando sea necesario
function clearMusicStorage() {
    localStorage.removeItem('musicPlaying');
    localStorage.removeItem('musicPosition');
}

// Guardar la posición de la música en localStorage al salir de la página
window.addEventListener('beforeunload', function() {
    console.log('Guardando posición antes de salir:', audio.currentTime); // Verifica la posición guardada
    localStorage.setItem('musicPosition', audio.currentTime); // Guardar la posición actual
    localStorage.setItem('musicPlaying', audio.paused ? 'false' : 'true'); // Guardar estado
});