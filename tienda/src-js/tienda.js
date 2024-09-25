const audio = document.getElementById('audioPlayer');
    const toggleButton = document.getElementById('toggleButton');

    // Al cargar la página, establecer el estado del audio desde localStorage
    window.onload = function() {
      // Comenzar la canción desde la última posición almacenada
      const savedTime = localStorage.getItem('audioTime');
      if (savedTime) {
        audio.currentTime = savedTime;
      }

      // Verificar el estado de reproducción (pausado o reproduciendo)
      const isPaused = localStorage.getItem('isPaused');
      if (isPaused === 'true') {
        audio.pause();
        toggleButton.textContent = 'Reproducir';
      } else {
        audio.play();
        toggleButton.textContent = 'Pausar';
      }
    };

    // Guardar el estado del audio cuando el usuario navega fuera de la página
    window.onbeforeunload = function() {
      localStorage.setItem('audioTime', audio.currentTime);
    };

    // Alternar entre pausar y reproducir la canción en todas las páginas
    toggleButton.onclick = function() {
      if (audio.paused) {
        audio.play();
        toggleButton.textContent = 'Pausar';
        localStorage.setItem('isPaused', 'false');
      } else {
        audio.pause();
        toggleButton.textContent = 'Reproducir';
        localStorage.setItem('isPaused', 'true');
      }
    };