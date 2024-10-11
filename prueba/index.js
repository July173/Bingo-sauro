// index.js

document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Segunda animación
        "https://lottie.host/f44610ef-1a20-4bb3-a042-59ebe90d7160/bw7GRcheBo.json"  // Primera animación
    ];

    // Función para manejar la animación y el mensaje de recompensa
    function handleAnimationClick(playerId, messageId) {
        const rewardAnimation = document.getElementById(playerId);
        const rewardMessage = document.getElementById(messageId);
        let currentAnimation = 0;

        rewardAnimation.addEventListener('click', () => {
            // Alternar entre las animaciones
            currentAnimation = (currentAnimation + 1) % animations.length;
            rewardAnimation.load(animations[currentAnimation]);

            // Mostrar el letrero de recompensa
            rewardMessage.style.display = "block";

            // Ocultar el letrero después de 3 segundos
            setTimeout(() => {
                rewardMessage.style.display = "none";
            }, 3000);
        });
    }

    // Aplicar la función a cada uno de los 6 cofres
    for (let i = 1; i <= 6; i++) {
        handleAnimationClick(`rewardAnimation${i}`, `rewardMessage${i}`);
    }
});
