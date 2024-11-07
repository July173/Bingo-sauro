// Generar el código
// Generar un código aleatorio desde PHP y luego redirigir
function generarCodigoPartida() {
    fetch('../php/crear_codigo.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const codigo = data.codigo;
                
                // Guardar el código en localStorage para usarlo en la otra pantalla
                localStorage.setItem('codigoPartida', codigo);
                
                // Redirigir a la otra pantalla
                window.location.href = 'otra_pantalla.html';
            } else {
                alert(data.error); // Mostrar mensaje de error si no se generó el código
            }
        })
        .catch(error => console.error('Error:', error));
}

const boton = document.getElementById('miBoton');

boton.addEventListener('click', generarCodigoPartida);



function unirseAPartida() {
    const codigo = document.getElementById('codigoEntrada').value;
    const nombre = document.getElementById('nombreJugador').value;
    const foto = 'ruta/a/la/foto.jpg'; // O selecciona la URL de la foto

    fetch('/Crearsala/php/unirsePartida.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `codigo=${codigo}&nombre=${nombre}&foto=${foto}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            agregarJugadorAlDOM(data.nombre, data.foto);
        } else {
            alert(data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

function agregarJugadorAlDOM(nombre, foto) {
    const contenedorJugadores = document.getElementById('contenedorJugadores');
    const jugadorDiv = document.createElement('div');
    jugadorDiv.classList.add('jugador');
    jugadorDiv.innerHTML = `<img src="${foto}" alt="${nombre}"><p>${nombre}</p>`;
    contenedorJugadores.appendChild(jugadorDiv);
}
