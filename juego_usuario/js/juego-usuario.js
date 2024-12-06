// Función para generar un cartón de Bingo
function generarCartonHtml() {
    const letras = ["B", "I", "N", "G", "O"];
    const rangos = [
        { min: 1, max: 15 },
        { min: 16, max: 30 },
        { min: 31, max: 45 },
        { min: 46, max: 60 },
        { min: 61, max: 75 }
    ];

    function obtenerNumerosUnicos(min, max, cantidad) {
        const numeros = new Set();
        while (numeros.size < cantidad) {
            const numero = Math.floor(Math.random() * (max - min + 1)) + min;
            numeros.add(numero);
        }
        return Array.from(numeros);
    }

    const carton = [];
    for (let i = 0; i < 5; i++) {
        carton[i] = obtenerNumerosUnicos(rangos[i].min, rangos[i].max, 5);
    }

    let tablaHtml = "<table class='carton-bingo'>";
    tablaHtml += "<tr>";
    letras.forEach(letra => {
        tablaHtml += `<th>${letra}</th>`;
    });
    tablaHtml += "</tr>";

    for (let fila = 0; fila < 5; fila++) {
        tablaHtml += "<tr>";
        for (let col = 0; col < 5; col++) {
            if (fila === 2 && col === 2) {
                tablaHtml += "<td class='libre'>LIBRE</td>";
            } else {
                tablaHtml += `<td>${carton[col][fila]}</td>`;
            }
        }
        tablaHtml += "</tr>";
    }
    tablaHtml += "</table>";

    return tablaHtml;
}

// Función para generar múltiples cartones
async function generarCartones() {
    const codigo = localStorage.getItem('codigoPartida');
    if (!codigo) {
        alert('Código de partida no encontrado.');
        return;
    }

    const contenedor = document.getElementById('contenedorCartones');
    contenedor.innerHTML = '<p>Cargando cartones...</p>'; // Mensaje mientras carga

    try {
        // Obtener la cantidad de cartones desde el servidor
        const response = await fetch(`./php/juego-usuario.php?codigoPartida=${codigo}`);
        if (!response.ok) {
            throw new Error(`Error al conectar con el servidor: ${response.statusText}`);
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error(data.error || 'No se pudo obtener la cantidad de cartones.');
        }

        const numeroCartones = data.numero_cartones;

        if (!Number.isInteger(numeroCartones) || numeroCartones <= 0) {
            throw new Error('El número de cartones obtenido no es válido.');
        }

        // Generar los cartones
        contenedor.innerHTML = ''; // Limpiar el contenedor
        for (let i = 0; i < numeroCartones; i++) {
            const cartonHtml = generarCartonHtml();
            const div = document.createElement('div');
            div.className = 'carton';
            div.innerHTML = cartonHtml;
            contenedor.appendChild(div);
        }
    } catch (error) {
        console.error('Error al generar cartones:', error);
        contenedor.innerHTML = '<p>Hubo un error al generar los cartones.</p>';
        alert(error.message);
    }
}

// Llamar a la función al cargar la página
window.onload = generarCartones;
