document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const codigoPartida = localStorage.getItem('codigoPartida');

    // Función para cargar datos del servidor
    async function cargarDatos() {
        try {
            const response = await fetch(`./php/consultar_datos.php?codigo_sala=${codigoPartida}`, {
                method: 'GET', // Especifica el método GET explícitamente
            });

            if (!response.ok) {
                throw new Error('Error en la consulta: ' + response.status);
            }

            // Convierte la respuesta a JSON
            const datos = await response.json();

            // Verifica si hay un error en los datos
            if (datos.error) {
                alert("erro");
            } else {
                // Inserta los datos en el DOM
                document.getElementById('minimoMonedas').textContent = `Minimo de dino-monedas para apostar: ${datos.monedas_minimas}`;
                document.getElementById('cartonesMaximos').textContent = `Cantidad maxima de cartones: ${datos.maximo_cartones}`;
            }
        } catch (error) {
            console.error('Error al cargar los datos:', error);
        }
    }

    const actualizarJugadores = () => {
        fetch('../crear_sala/php/consultar_jugadores.php?filtros=true')
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
                            <div style="display: flex; align-items: center; gap: 15px; border-bottom: 1px solid #ddd; padding: 10px;">
                                <img src="${jugador.avatar}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #4CAF50;">
                                <div>
                                    <p style="margin: 0; font-size: 14px; font-weight: bold; color: #333;">${jugador.nombre}</p>
                                    <p style="margin: 5px 0 0; font-size: 13px; color: #666;">Cartones: ${jugador.cartones}</p>
                                </div>
                            </div>
                        `;
    
                        listaJugadores.appendChild(jugadorDiv);
                    });
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error al consultar jugadores:', error));
    };

    // Cargar el estado inicial de los cofres
    cargarDatos();

    // Actualizar cada 5 segundos
    setInterval(actualizarJugadores, 5000);

    // Llamada inicial
    actualizarJugadores();
});