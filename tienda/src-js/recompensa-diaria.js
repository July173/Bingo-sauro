document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const rewardsContainer = document.getElementById('rewardsContainer'); // Contenedor de recompensas
    const messageBox = document.getElementById('messageBox'); // Elemento para mostrar mensajes al usuario

    // Función para mostrar mensajes al usuario
    function mostrarMensaje(texto, tipo = 'info') {
        messageBox.textContent = texto;
        messageBox.className = `message-box ${tipo}`; // Clase CSS según el tipo de mensaje
        setTimeout(() => {
            messageBox.textContent = '';
            messageBox.className = 'message-box'; // Restaurar estilo base
        }, 5000); // El mensaje desaparece después de 5 segundos
    }

    // Función para cargar el estado de los cofres
    async function cargarCofres() {
        try {
            const response = await fetch('./src-php/obtener_estado_cofres.php', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });

            const data = await response.json();
            if (data.success) {
                console.log('Estado de cofres:', data.dias);
                actualizarUI(data.dias);
            } else {
                mostrarMensaje('Error al cargar cofres: ' + data.error, 'error');
            }
        } catch (error) {
            console.error('Error al cargar cofres:', error);
            mostrarMensaje('Error al conectar con el servidor para cargar cofres.', 'error');
        }
    }

    // Función para reclamar una recompensa
    async function reclamarRecompensa(fecha) {
        try {
            const response = await fetch('./src-php/reclamar_recompensa.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ fecha })
            });

            const data = await response.json();
            if (data.success) {
                mostrarMensaje(`¡Felicidades! Has ganado ${data.monedas} monedas.`, 'success');
                cargarCofres(); // Actualizar el estado después de reclamar
            } else {
                mostrarMensaje(`Error al reclamar recompensa: ${data.error}`, 'error');
            }
        } catch (error) {
            console.error('Error al reclamar recompensa:', error);
            mostrarMensaje('Error al conectar con el servidor.', 'error');
        }
    }

    // Función para actualizar la interfaz con los estados de los cofres
    function actualizarUI(estados) {
        estados.forEach((estado, index) => {
            const rewardElement = document.getElementById(`rewardAnimation${index + 1}`);
            if (rewardElement) {
                const estadoClase = estado.estado === 'disponible' ? 'available' : (estado.estado === 'reclamado' ? 'claimed' : 'locked');
                rewardElement.className = `reward-animation ${estadoClase}`;

                rewardElement.addEventListener('click', () => {
                    if (estado.estado === 'disponible') {
                        reclamarRecompensa(estado.fecha);
                    } else if (estado.estado === 'reclamado') {
                        mostrarMensaje('Recompensa ya reclamada.', 'warning');
                    } else {
                        mostrarMensaje('Este cofre no está disponible aún.', 'error');
                    }
                });
            }
        });
    }

    // Inicializar la lógica para los cofres
    for (let i = 1; i <= 7; i++) {
        const rewardElement = document.getElementById(`rewardAnimation${i}`);

        if (rewardElement) {
            let currentAnimation = 0;

            rewardElement.addEventListener('click', () => {
                currentAnimation = (currentAnimation + 1) % animations.length;
                rewardElement.load(animations[currentAnimation]);
            });
        }
    }

    // Cargar el estado inicial de los cofres
    cargarCofres();
});