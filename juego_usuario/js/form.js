document.getElementById('redirigirJuego').addEventListener('click', async () => {
    const monedas = document.getElementById('monedasApostar').value;
    const cartones = document.getElementById('cartones').value;
    const codigo = localStorage.getItem('codigoPartida');

    if (!monedas || !cartones) {
        alert('Por favor, completa ambos campos antes de continuar.');
        return;
    }

    if (!codigo) {
        alert('Código de partida no encontrado. Intenta recargar la página.');
        return;
    }

    try {
        // Solicitud GET para obtener restricciones
        const response = await fetch(`./php/enviar_datos.php?codigo=${codigo}`, { method: 'GET' });
        const restricciones = await response.json();

        if (!restricciones.success) {
            alert(restricciones.error || 'Error al obtener restricciones.');
            return;
        }

        const { monedas_minimas, maximo_cartones } = restricciones;

        // Validaciones locales
        if (monedas < monedas_minimas) {
            alert(`La cantidad mínima de monedas para apostar es ${monedas_minimas}.`);
            return;
        }
        if (cartones > maximo_cartones) {
            alert(`El número máximo de cartones es ${maximo_cartones}.`);
            return;
        }

        // Solicitud POST para enviar datos
        const postResponse = await fetch('./php/enviar_datos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ monedas, cartones, codigo }),
        });

        const postData = await postResponse.json();

        if (postData.success) {
            alert(postData.message);
            window.location.href = './juego-usuario.php';
        } else {
            alert(postData.error || 'Error al enviar los datos.');
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Error en el proceso.');
    }
});
