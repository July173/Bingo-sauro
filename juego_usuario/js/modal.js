const openModal = document.getElementById('openModal');
const yesBtn = document.getElementById('yesBtn');
const noBtn = document.getElementById('noBtn');
const modal = new bootstrap.Modal(document.getElementById('questionModal'));

// Abrir el modal al hacer clic en el ícono
openModal.addEventListener('click', () => {
    modal.show();
});

// Función para eliminar el código de la partida
async function eliminarCodigoPartida(codigoPartida) {
    try {
        const response = await fetch('./php/salir-partida.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ codigoPartida })
        });

        if (!response.ok) {
            throw new Error(`HTTP status ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            console.log(data.message);
            alert(data.message);  // Muestra el mensaje de éxito
            if (data.redirect) {
                window.location.href = data.redirectUrl; // Redirige a la URL proporcionada
            }
        } else {
            console.error(data.message);
            alert("Error: " + data.message);
        }
        
    } catch (error) {
        console.error('Error al eliminar el código de la partida:', error);
    }
}

// Redirigir a otra página si hace clic en "Sí"
yesBtn.addEventListener('click', () => {
    const codigoPartida = localStorage.getItem('codigoPartida');
    console.log('Código de partida para eliminar:', codigoPartida); // Para verificar
    if (codigoPartida) {
        eliminarCodigoPartida(codigoPartida);
    } else {
        console.error('Código de partida no disponible.');
    }
});

// Cerrar el modal si hace clic en "No"
noBtn.addEventListener('click', () => {
    modal.hide();
});
