const historialDiv = document.getElementById('historialJugar');  
  
  
  
  // Simulamos cargar el archivo JSON
  const historialData = [
    { fecha: '2024-09-01', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'Ganó' },
    { fecha: '2024-09-02', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'Perdió' }
    ,
    { fecha: '2024-09-02', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'Perdió' }
    ,
    { fecha: '2024-09-02', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'Ganó' }
    ,
    { fecha: '2024-09-02', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'PGanó' }
    ,
    { fecha: '2024-09-02', carton: '/Generales/img/cartoncitoHistorial.png', resultado: 'Perdió' }
      
  ];

  // Referencia al contenedor donde se mostrará el historial
  function mostrarHistorial(historial) {
    historialDiv.innerHTML = ''; // Limpiar contenido previo
    if (historial.length === 0) {
      historialDiv.innerHTML = '<p class="mensaje-vacio">No hay partidas jugadas.</p>';
      return;
    }
  
    historial.forEach(partida => {
      const partidaDiv = document.createElement('div');
      partidaDiv.classList.add('partida');
  
      // Verificar el resultado y usar el ícono correspondiente
      const iconoResultado = partida.resultado === 'Ganó' ? '✔' : '✖';
      const resultadoClass = partida.resultado === 'Ganó' ? 'ganado' : 'perdido';
  
      // Insertar imagen del cartón en lugar de texto
      const cartonImagen = `<img src="${partida.carton}" alt="Cartón" class="carton-imagen">`;
  
      partidaDiv.innerHTML = `
        <span>${partida.fecha}</span>
        <span>${cartonImagen}</span>
        <span class="${resultadoClass}">${iconoResultado}</span>
      `;
  
      historialDiv.appendChild(partidaDiv);
    });
  }
  // Llamada a la función con los datos simulados
  mostrarHistorial(historialData);  



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