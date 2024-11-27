function generarCarton() {
    const letras = ["B", "I", "N", "G", "O"];
    const rangos = [
        {min: 1, max: 15},   // Rango para columna B
        {min: 16, max: 30},  // Rango para columna I
        {min: 31, max: 45},  // Rango para columna N
        {min: 46, max: 60},  // Rango para columna G
        {min: 61, max: 75}   // Rango para columna O
    ];

    // Función para generar un conjunto de números aleatorios únicos en un rango
    function obtenerNumerosUnicos(min, max, cantidad) {
        const numeros = new Set();
        while (numeros.size < cantidad) {
            const numero = Math.floor(Math.random() * (max - min + 1)) + min;
            numeros.add(numero);
        }
        return Array.from(numeros);
    }

    // Generar números para cada columna
    const carton = [];
    for (let i = 0; i < 5; i++) {
        carton[i] = obtenerNumerosUnicos(rangos[i].min, rangos[i].max, 5);
    }

    // Crear la tabla de Bingo
    let tablaHtml = "<table>";
    tablaHtml += "<tr>";
    letras.forEach(letra => {
        tablaHtml += `<th>${letra}</th>`;
    });
    tablaHtml += "</tr>";

    for (let fila = 0; fila < 5; fila++) {
        tablaHtml += "<tr>";
        for (let col = 0; col < 5; col++) {
            // Colocar el centro libre en la posición N-3
            if (fila === 2 && col === 2) {
                tablaHtml += "<td>LIBRE</td>";
            } else {
                tablaHtml += `<td>${carton[col][fila]}</td>`;
            }
        }
        tablaHtml += "</tr>";
    }
    tablaHtml += "</table>";

    // Mostrar el cartón en el contenedor
    document.getElementById("bingo-carton").innerHTML = tablaHtml;
}

// Generar el primer cartón al cargar la página
generarCarton();