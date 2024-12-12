// Seleccionar elementos
const bolaOverlay = document.getElementById('bola-overlay');
const bolaImg = document.getElementById('bola-img');
const balotera = document.getElementById('baloteraImg');

// URL de la API para obtener la bola
const apiUrl = './php/get_bola_random.php';

//Obtener el código de la partida desde localStorage

// Función para girar la balotera y obtener la bola aleatoria
async function girarBombo() {
    const imagenOriginal = './../generales/img/boleteraQuieta.png';
    const imagenGirando = './../generales/img/boleteraMoviendose.png';
    const codigo = localStorage.getItem('codigoPartida');
    
    if (!codigo) {
      alert('Código de partida no encontrado. Intenta recargar la página.');
      return;
  }
    try {
        // Iniciar el movimiento de la balotera
        balotera.src = imagenGirando;

        // Esperar a que termine el movimiento de la balotera (700 ms)
        await new Promise((resolve) => setTimeout(resolve, 700));

        // Volver a la imagen original de la balotera
        balotera.src = imagenOriginal;

        // Hacer la solicitud para obtener la bola aleatoria
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({codigo}), // Aquí se incluye el código

        });

        const data = await response.json();

        // Verificar si hubo un error en la respuesta
        if (!data.success) {
            alert('Error al obtener la bola: ' + data.message);
            return;
        }

        // Mostrar la imagen de la bola en el overlay
        bolaImg.src = data.data.url;
        bolaOverlay.style.display = 'flex'; // Mostrar el overlay

        // Animar la bola de pequeña a grande
        setTimeout(() => {
            bolaImg.style.width = '40vw'; // Tamaño final deseado
        }, 50); // Breve retraso para iniciar la transición

        // Ocultar la bola automáticamente después de 3 segundos
        setTimeout(() => {
            bolaImg.style.width = '0'; // Reducir el tamaño de nuevo
            setTimeout(() => {
                bolaOverlay.style.display = 'none'; // Ocultar el overlay
                bolaImg.src = ''; // Limpiar la imagen
            }, 500); // Coincide con la duración de la transición
        }, 3000); // Duración visible antes de ocultar
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Hubo un error al obtener la bola. Intenta de nuevo.');
    }
}

// Agregar evento para ejecutar la función cuando sea necesario
document.getElementById('start-button')?.addEventListener('click', girarBombo); // Cambia el ID al botón que activa la función
