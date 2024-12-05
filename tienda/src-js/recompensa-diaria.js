document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const rewardsContainer = document.getElementById('rewardsContainer'); // Contenedor de recompensas
    const messageBox = document.getElementById('messageBox'); // Elemento para mostrar mensajes al usuario

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

    async function reclamarRecompensa(fecha, cantidadMonedas) {
        try {
            const response = await fetch('./src-php/reclamar_recompensa.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ fecha, cantidadMonedas }) // La fecha se envía en formato JSON
            });
    
            const data = await response.json();
    
            if (data.success) {
                mostrarMensajeConTemporizador(`¡Felicidades! Has ganado ${data.monedas} monedas.`, 'success');
                cargarCofres(); // Actualizar el estado después de reclamar
            } else {
                mostrarMensajeConTemporizador(`Error al reclamar recompensa: ${data.error}`, 'error');
            }
        } catch (error) {
            console.error('Error al reclamar recompensa:', error.error);
            mostrarMensajeConTemporizador('Error al conectar con el servidor.', 'error');
        }
    }
    
    // Función para manejar mensajes en `congratulationsMessage`
    function mostrarMensajeConTemporizador(texto) {
        const congratulationsMessage = document.getElementById('congratulationsMessage');
        congratulationsMessage.textContent = texto; // Actualizar el texto
        congratulationsMessage.style.display = 'block'; // Mostrar el mensaje
    
        setTimeout(() => {
            congratulationsMessage.style.display = 'none'; // Ocultar el mensaje
            congratulationsMessage.textContent = ''; // Limpiar el texto
        }, 5000); // El mensaje desaparece después de 5 segundos
    }
    

    function actualizarUI(estados) {
        const rewardsContainer = document.getElementById('rewardsContainer');
        const congratulationsMessage = document.getElementById('congratulationsMessage');
        rewardsContainer.innerHTML = ''; // Limpia cualquier cofre previamente creado
    
        estados.forEach((estado, index) => {
            // Crear el contenedor del cofre
            const rewardElement = document.createElement('div');
            rewardElement.classList.add('reward-animation');
            rewardElement.id = `rewardAnimation${index + 1}`; // Asignar un id dinámico
    
            // Determinar la clase visual según el estado
            let estadoClase = 'darkened'; // Base oscura
            if (estado.dia === 'AYER') {
                estadoClase = !estado.encontrado ? 'darkened-red' : 'darkened-green';
            } else if (estado.dia === 'HOY') {
                estadoClase = estado.encontrado ? 'darkened' : 'normal';
            } else if (estado.dia === 'MAÑANA') {
                estadoClase = 'darkened-yellow';
            }
            rewardElement.classList.add(estadoClase);
    
            // Crear el contenedor del cofre con la información
            const rewardContainer = document.createElement('div');
            rewardContainer.classList.add('reward-container');
    
            // Mostrar la fecha en el encabezado
            const rewardHeader = document.createElement('div');
            rewardHeader.classList.add('reward-header');
            rewardHeader.textContent = estado.dia;
    
            // Crear el contenedor de la animación Lottie
            const circleContainer = document.createElement('div');
            circleContainer.classList.add('circle-container');
    
            // Crear el elemento Lottie
            const lottiePlayer = document.createElement('dotlottie-player');
            lottiePlayer.id = `rewardAnimation${index + 1}`;
            lottiePlayer.src = 'https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json';
            lottiePlayer.setAttribute('background', 'transparent');
            lottiePlayer.setAttribute('speed', '1');
            lottiePlayer.setAttribute('style', 'width: 150px; height: 150px;');
            lottiePlayer.setAttribute('loop', 'true');
            lottiePlayer.setAttribute('autoplay', 'true');
    
            // Añadir el Lottie player al contenedor de la animación
            circleContainer.appendChild(lottiePlayer);
    
            // Añadir el encabezado y la animación al contenedor del cofre
            rewardContainer.appendChild(rewardHeader);
            rewardContainer.appendChild(circleContainer);
    
            // Agregar el contenedor al cofre
            rewardElement.appendChild(rewardContainer);
    
            // Agregar el evento de clic para mostrar el mensaje y reclamar recompensa
            rewardElement.addEventListener('click', () => {
                // Si el día es "HOY" y no está encontrado, reclamar recompensa
                if (estado.dia === 'HOY' && !estado.encontrado) {
                    // Mostrar confirmación antes de reclamar
                    const confirmacion = confirm("¿Estás seguro de que quieres reclamar esta recompensa?");
                    if (confirmacion) {
                        console.log("Se llama a reclamar recompensa");
                        reclamarRecompensa(estado.fecha, estado.monedas); // Pasar la fecha correspondiente
                    }else{
                        congratulationsMessage.textContent = estado.mensaje; // Actualizar el texto
                        congratulationsMessage.style.display = 'block'; // Mostrar el mensaje
                    }
                }else{
                    congratulationsMessage.textContent = estado.mensaje; // Actualizar el texto
                    congratulationsMessage.style.display = 'block'; // Mostrar el mensaje
                }
    
                // Ocultar el mensaje después de 5 segundos
                setTimeout(() => {
                    congratulationsMessage.style.display = 'none';
                    congratulationsMessage.textContent = ''; // Limpiar el contenido
                }, 5000);
            });
    
            // Añadir el cofre al contenedor principal
            rewardsContainer.appendChild(rewardElement);
        });
    }
    
    // Cargar el estado inicial de los cofres
    cargarCofres();
});