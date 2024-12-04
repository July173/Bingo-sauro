
const actualizarJugadores = () => {
    fetch('./php/consultar_jugadores.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const jugadores = data.jugadores;
                const listaJugadores = document.getElementById('lista-jugadores');
                listaJugadores.innerHTML = ''; // Limpiar la lista actual

                jugadores.forEach(jugador => {
                    const jugadorDiv = document.createElement('div');
                    jugadorDiv.style.display = 'flex';
                    jugadorDiv.style.flexDirection = 'column';
                    jugadorDiv.style.alignItems = 'center';
                    jugadorDiv.style.margin = '10px';
                    jugadorDiv.style.border = '1px solid #ccc';
                    jugadorDiv.style.borderRadius = '10px';
                    jugadorDiv.style.padding = '10px';
                    jugadorDiv.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';

                    jugadorDiv.innerHTML = `
                        <img src="${jugador.avatar}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <p style="margin-top: 10px; font-size: 14px; font-weight: bold;">${jugador.nombre}</p>
                    `;

                    listaJugadores.appendChild(jugadorDiv);
                });
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error al consultar jugadores:', error));
};

// Actualizar cada 5 segundos
setInterval(actualizarJugadores, 5000);

// Llamada inicial
actualizarJugadores();
