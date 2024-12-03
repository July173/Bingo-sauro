document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const rewardAlert = document.getElementById('rewardAlert'); // Contenedor para mensajes de recompensa
    console.log(rewardAlert); // Verificar si se encuentra el contenedor

    // Función para manejar la animación y el mensaje de recompensa
    function handleAnimationClick(playerId, dayNumber) {
        const rewardAnimation = document.getElementById(playerId);
        let currentAnimation = 0;

        rewardAnimation.addEventListener('click', () => {
            // Alternar entre las animaciones
            currentAnimation = (currentAnimation + 1) % animations.length;
            rewardAnimation.load(animations[currentAnimation]);

            // Reclamar la recompensa diaria
            reclamarRecompensa(dayNumber);
        });
    }

    // Función para reclamar la recompensa diaria
    function reclamarRecompensa(dia) {
        fetch(`./php/recompensa_diaria.php?dia=${dia}`) // Llamar al script PHP con el día
            .then(response => response.json())
            .then(data => {
                console.log(data); // Verificar la respuesta del servidor
                rewardAlert.innerText = data.mensaje; // Mostrar el mensaje de la respuesta
                rewardAlert.style.display = "block"; // Hacer visible el contenedor

                // Ocultar el mensaje después de 3 segundos
                setTimeout(() => {
                    rewardAlert.style.display = "none";
                }, 3000);

                if (data.cantidad) {
                    // Actualizar el saldo de monedas del usuario
                    document.getElementById('saldo').innerText = `Saldo: ${data.cantidad}`;
                }
            })
            .catch(error => console.error('Error al reclamar la recompensa:', error));
    }

    // Aplicar la función a cada uno de los 6 cofres, pasando el número del día
    for (let i = 1; i <= 6; i++) {
        handleAnimationClick(`rewardAnimation${i}`, i);
    }

    // Manejo especial para la imagen del Día 7
    const day7Image = document.getElementById('rewardImage7');

    day7Image.addEventListener('click', () => {
        // Reclamar la recompensa del Día 7
        reclamarRecompensa(7);
    });

    function cargarCofres() {
        fetch('ruta/obtener_estado_cofres.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                const cofresContainer = document.getElementById('cofres');
                cofresContainer.innerHTML = '';

                data.dias.forEach(dia => {
                    const cofreDiv = document.createElement('div');
                    cofreDiv.className = `cofre ${dia.reclamado ? 'reclamado' : 'no-reclamado'}`;
                    cofreDiv.innerHTML = `
                        <p>${dia.fecha}</p>
                        <p>${dia.monedas} monedas</p>
                    `;
                    if (!dia.reclamado) {
                        const boton = document.createElement('button');
                        boton.textContent = 'Reclamar';
                        boton.onclick = () => reclamarCofre(dia.fecha);
                        cofreDiv.appendChild(boton);
                    }
                    cofresContainer.appendChild(cofreDiv);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function reclamarCofre(fecha) {
        fetch('ruta/reclamar_recompensa.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `fecha=${fecha}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(`Has reclamado ${data.monedas} monedas.`);
                    cargarCofres(); // Recargar los cofres
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function irUltimaPagina() {
        const cofres = document.querySelectorAll('.cofre');
        const hoy = new Date().toISOString().slice(0, 10); // Fecha actual en formato YYYY-MM-DD

        let ultimaPagina = 0;
        cofres.forEach((cofre, index) => {
            if (cofre.querySelector('p').textContent === hoy) {
                ultimaPagina = Math.floor(index / 6); // 6 cofres por página
            }
        });

        mostrarPagina(ultimaPagina);
    }
});