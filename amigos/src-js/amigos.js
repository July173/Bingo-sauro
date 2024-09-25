const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos

// Simulamos cargar el archivo JSON
const amigosData = [
  { Nombres: 'Juanito' },
  { Nombres: 'Ana' },
  { Nombres: 'Luis' },
  { Nombres: 'Carlos' },
  { Nombres: 'Marta' },
  { Nombres: 'Sofia' }
];

// Función para mostrar los amigos
function mostrarAmigos(amigos) {
  amigosDiv.innerHTML = ''; // Limpiar contenido previo
  if (amigos.length === 0) {
    amigosDiv.innerHTML = '<p class="mensaje-vacio">No hay aún amigos agregados.</p>';
    return;
  }

  amigos.forEach(amigo => {
    const amigoDiv = document.createElement('div');
    amigoDiv.classList.add('amigo'); // Clase para el estilo

    amigoDiv.innerHTML = `
      <span>${amigo.Nombres}</span>
    `;

    amigosDiv.appendChild(amigoDiv);
  });
}

// Llamada a la función con los datos simulados
mostrarAmigos(amigosData);

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