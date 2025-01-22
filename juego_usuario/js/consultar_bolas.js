const bolaOverlay = document.getElementById('bolaOverlay');
const bolaImg = document.getElementById('bolaImg');
let bolasMostradas = new Set(); // Almacena las bolas ya mostradas
const codigoSala = localStorage.getItem('codigoPartida'); // Código de la sala desde localStorage

// Función para mostrar la animación de una bola
function mostrarBolaAnimada(bola) {
  const { letra, numero_llamada, url } = bola;

  // Actualiza la imagen y muestra el overlay
  bolaImg.src = url;
  bolaOverlay.style.display = 'flex';

  // Animación de entrada
  setTimeout(() => {
    bolaImg.style.width = '40vw'; // Tamaño final deseado
  }, 50);

  // Ocultar automáticamente después de 3 segundos
  setTimeout(() => {
    bolaImg.style.width = '0'; // Reducir el tamaño
    setTimeout(() => {
      bolaOverlay.style.display = 'none'; // Ocultar overlay
      bolaImg.src = ''; // Limpiar la imagen
    }, 500);
  }, 2000);
}

// Función para consultar las bolas desde el servidor
async function consultarBolas() {
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

      // Filtrar las bolas que aún no se han mostrado
      const bolasNuevas = bolas.filter(
        (bola) => !bolasMostradas.has(bola.numero_llamada)
      );

      // Agregar las nuevas bolas al Set
      bolasNuevas.forEach((bola) =>
        bolasMostradas.add(bola.numero_llamada)
      );

      // Mostrar las nuevas bolas
      bolasNuevas.forEach(mostrarBolaAnimada);
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error al consultar las bolas:', error);
  }
}

// Configurar el intervalo de consulta (cada 2 segundos)
document.addEventListener('DOMContentLoaded', () => {
  if (codigoSala) {
    setInterval(consultarBolas, 2000); // Consulta al servidor cada 2 segundos
  } else {
    console.error('No se encontró el código de la sala');
  }
});
