document.querySelectorAll('.toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
        this.classList.toggle('off');
    });
});

const audio = document.getElementById('audioPlayer');
    const soundToggle = document.getElementById('soundToggle');

    // Al cargar la página, establecer el estado del audio desde localStorage
    window.onload = function() {
      // Recuperar el tiempo guardado del audio
      const savedTime = localStorage.getItem('audioTime');
      if (savedTime) {
        audio.currentTime = savedTime;
      }

      // Verificar si el audio estaba pausado o reproduciéndose
      const isPaused = localStorage.getItem('isPaused');
      if (isPaused === 'true') {
        audio.pause();
        soundToggle.classList.add('off');
      } else {
        audio.play();
        soundToggle.classList.remove('off');
      }
    };

    // Guardar el tiempo actual del audio al salir de la página
    window.onbeforeunload = function() {
      localStorage.setItem('audioTime', audio.currentTime);
    };

    // Alternar entre pausar y reproducir el audio
    soundToggle.onclick = function() {
      soundToggle.classList.toggle('off');

      if (audio.paused) {
        audio.play();
        localStorage.setItem('isPaused', 'false');
      } else {
        audio.pause();
        localStorage.setItem('isPaused', 'true');
      }
    };