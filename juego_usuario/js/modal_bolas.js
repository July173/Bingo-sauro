const modalbolas = document.getElementById('modalBolas');
const contenedorBolas = document.getElementById('contenedorBolas');
const cerrarModal = document.getElementById('cerrarModal');
const botonObtenerBolas = document.getElementById('botonObtenerBola');

// Función para mostrar el modal
function mostrarModal() {
  modalbolas.style.display = 'flex';
}

// Función para cerrar el modal
cerrarModal.addEventListener('click', () => {
  modalbolas.style.display = 'none';
  contenedorBolas.innerHTML = ''; // Limpiar el contenedor al cerrar el modal
});

// Función para obtener las bolas desde el servidor
async function obtenerBolas(codigoSala) {
  try {
    const response = await fetch('../juego_admi/php/bolas_mostradas.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ codigo: codigoSala }),
    });

    const data = await response.json();

    if (data.success) {
      const bolas = data.data;

      // Limpiar el contenedor de bolas antes de agregar nuevas
      contenedorBolas.innerHTML = '';

      // Iterar sobre las bolas y agregarlas al contenedor
      bolas.forEach((bola) => {
        const { letra, numero_llamada, url } = bola;

        const bolaDiv = document.createElement('div');
        bolaDiv.classList.add('bola');

        bolaDiv.innerHTML = `
          <img src="${url}" alt="Bola ${letra}${numero_llamada}">
          <p class="pbola">${letra}</p>
        `;

        contenedorBolas.appendChild(bolaDiv);
      });

      // Mostrar el modal
      mostrarModal();
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error al obtener las bolas:', error);
  }
}

// Configurar el botón para abrir el modal y cargar las bolas
document.addEventListener('DOMContentLoaded', () => {
  const codigoSala = localStorage.getItem('codigoPartida'); // Obtener el código de la partida desde localStorage

  botonObtenerBolas.addEventListener('click', () => {
    if (codigoSala) {
      obtenerBolas(codigoSala); // Cargar las bolas y mostrar el modal
    } else {
      console.error('No se encontró el código de la sala');
    }
  });
});
