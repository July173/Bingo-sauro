// Seleccionar elementos
const bolaOverlay = document.getElementById('bola-overlay');
const bolaImg = document.getElementById('bola-img');
const balotera = document.getElementById('baloteraImg');

// Función para girar la balotera y obtener la bola
async function girarBombo() {
  const imagenOriginal = './../generales/img/boleteraQuieta.png';
  const imagenGirando = './../generales/img/boleteraMoviendose.png';

  try {
    // Iniciar el movimiento de la balotera
    balotera.src = imagenGirando;

    // Esperar a que termine el movimiento de la balotera (700 ms)
    await new Promise((resolve) => setTimeout(resolve, 700));

    // Volver a la imagen original de la balotera
    balotera.src = imagenOriginal;

    // Hacer la solicitud para obtener la bola aleatoria
    const response = await fetch('./php/get_bola_random.php');
    const data = await response.json();

    // Verificar si hubo un error
    if (data.error) {
      alert('Error al obtener la bola: ' + data.error);
      return;
    }

    // Mostrar la imagen en el overlay
    bolaImg.src = data.url;
    bolaOverlay.style.display = 'flex'; // Mostrar el overlay

    // Animar la bola de pequeña a grande
    setTimeout(() => {
      bolaImg.style.width = '40vw'; // Tamaño final deseado
    }, 50); // Breve retraso para asegurar que la transición ocurra

    // Ocultar la bola automáticamente después de 3 segundos
    setTimeout(() => {
      bolaImg.style.width = '0'; // Reducir el tamaño de nuevo
      setTimeout(() => {
        bolaOverlay.style.display = 'none'; // Ocultar el overlay después de la animación
        bolaImg.src = ''; // Limpiar la imagen
      }, 500); // Coincide con la duración de la transición
    }, 2000); // Duración visible antes de ocultar
  } catch (error) {
    console.error('Error en la solicitud:', error);
    alert('Hubo un error al obtener la bola. Intenta de nuevo.');
  }
}
