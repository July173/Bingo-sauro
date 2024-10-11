const historialDiv = document.getElementById('historialJugar');
const url= '../historial/historial.json';
// Función para cargar el historial desde el archivo PHP
function cargarHistorial() {
  fetch(url)
    .then(response => response.json())
    .then(historialData => {
      mostrarHistorial(historialData);
    })
    .catch(error => {
      console.error('Error al cargar el historial:', error);
      historialDiv.innerHTML = '<p class="mensaje-vacio">No se pudo cargar el historial.</p>';
    });
}

// Función para mostrar el historial
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

    // Insertar el ícono de calendario antes de la fecha
    partidaDiv.innerHTML = `
      <span style="border-bottom: 4px solid #000;">
        <i class="fa-solid fa-calendar-days"></i> ${partida.fecha}
      </span>
      <span>${cartonImagen}</span>
      <span class="${resultadoClass}">${iconoResultado}</span>
    `;

    historialDiv.appendChild(partidaDiv);
  });
}

// Llamada a la función para cargar el historial
cargarHistorial();

