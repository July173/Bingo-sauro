const historialDiv = document.getElementById('historialJugar');
const url = './php/partidas.php'; // Ruta actualizada para acceder al PHP

function cargarHistorial() {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok' + response.statusText);
            }
            return response.json();
        })
        .then(historialData => {
            mostrarHistorial(historialData);
        })
        .catch(error => {
            console.error('Error al cargar el historial js:', error);
            historialDiv.innerHTML = '<p class="mensaje-vacio">No hay partidas jugadas.</p>';
        });
}

function mostrarHistorial(historial) {
    console.log("se inicia a mostrar el historial");
    console.log("historial", historial);
    historialDiv.innerHTML = ''; // Limpiar contenido previo
    if (historial.length === 0) {
        historialDiv.innerHTML = '<p class="mensaje-vacio">No hay partidas jugadas.</p>';
        return;
    }

    historial.forEach(partida => {
        const partidaDiv = document.createElement('div');
        partidaDiv.classList.add('partida');

        const iconoResultado = partida.resultado === 'Ganó' ? '✔' : '✖';
        const resultadoClass = partida.resultado === 'Ganó' ? 'ganado' : 'perdido';
        const cartonImagen = `<img src="${partida.carton}" alt="Cartón" class="carton-imagen">`;

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
