document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const congratulationsMessage = document.getElementById('congratulationsMessage');

    // Función para manejar la animación y el mensaje de recompensa
    function handleAnimationClick(playerId, messageId, dayNumber) {
        const rewardAnimation = document.getElementById(playerId);
        const rewardMessage = document.getElementById(messageId);
        let currentAnimation = 0;

        rewardAnimation.addEventListener('click', () => {
            // Alternar entre las animaciones
            currentAnimation = (currentAnimation + 1) % animations.length;
            rewardAnimation.load(animations[currentAnimation]);

            // Mostrar el mensaje de felicitaciones con el número del día
            congratulationsMessage.innerText = `¡Felicidades! Has desbloqueado el Día ${dayNumber}.`;
            congratulationsMessage.style.display = "block";

            // Ocultar el mensaje después de 3 segundos
            setTimeout(() => {
                congratulationsMessage.style.display = "none";
            }, 3000);

            // Mostrar el letrero de recompensa
            rewardMessage.style.display = "block";

            // Ocultar el letrero después de 3 segundos
            setTimeout(() => {
                rewardMessage.style.display = "none";
            }, 3000);
        });
    }

    // Aplicar la función a cada uno de los 6 cofres, pasando el número del día
    for (let i = 1; i <= 6; i++) {
        handleAnimationClick(`rewardAnimation${i}`, `rewardMessage${i}`, i);
    }

    // Manejo especial para la imagen del Día 7
    const day7Image = document.getElementById('rewardImage7');
    const rewardMessage7 = document.getElementById('rewardMessage7');

    day7Image.addEventListener('click', () => {
        // Mostrar mensaje de felicitaciones para el Día 7
        congratulationsMessage.innerText = '¡Felicidades! Has alcanzado la recompensa del Día 7.';
        congratulationsMessage.style.display = 'block';

        // Ocultar el mensaje después de 3 segundos
        setTimeout(() => {
            congratulationsMessage.style.display = 'none';
        }, 3000);

        // Mostrar el letrero de recompensa
        rewardMessage7.style.display = 'block';

        // Ocultar el letrero de recompensa después de 3 segundos
        setTimeout(() => {
            rewardMessage7.style.display = 'none';
        }, 3000);
    });

    // Función para reclamar la recompensa diaria
    function reclamarRecompensa() {
        fetch('./php/recompensa_diaria.php') // Llamar al script PHP
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje); // Mostrar el mensaje de la respuesta
                if (data.cantidad) {
                    // Actualizar el saldo de monedas del usuario
                    document.getElementById('saldo').innerText = `Saldo: ${data.cantidad}`;
                }
            })
            .catch(error => console.error('Error al reclamar la recompensa:', error));
    }

    // Llama a la función cuando el usuario haga clic en un botón
    const botonReclamar = document.getElementById('botonReclamar');
    if (botonReclamar) {
        botonReclamar.addEventListener('click', reclamarRecompensa); // Agregar el evento de clic
    }
});
