document.getElementById('redirigirJuego').addEventListener('click', async () => {
    // Obtener los valores de los campos
    const monedas = document.getElementById('monedasApostar').value;
    const cartones = document.getElementById('cartones').value;

    // Validar que ambos campos estén llenos
    if (!monedas || !cartones) {
        alert('Por favor, completa ambos campos antes de continuar.');
        return;
    }

    try {
        // Obtener las monedas mínimas y los cartones máximos (puedes hacer esto con una consulta adicional o como parte de la respuesta del servidor)
        const response = await fetch('./php/obtener_restricciones.php', { method: 'GET' });
        const restricciones = await response.json();

        const monedasMinimas = restricciones.monedas_minimas;
        const maximoCartones = restricciones.maximo_cartones;

        // Validar que las monedas sean suficientes y los cartones no excedan el límite
        if (monedas < monedasMinimas) {
            alert(`La cantidad mínima de monedas para apostar es ${monedasMinimas}.`);
            return;
        }

        if (cartones > maximoCartones) {
            alert(`El número máximo de cartones es ${maximoCartones}.`);
            return;
        }

        // Enviar los datos al servidor
        const serverResponse = await fetch('./php/enviar_datos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ monedas, cartones }),
        });

        const data = await serverResponse.json();

        if (data.success) {
            alert(data.message); // Mostrar mensaje de éxito
            window.location.href = './juego-usuario.php'; // Redirigir a la página deseada
        } else {
            alert(data.error || data.message); // Mostrar mensaje de error
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Error al enviar los datos.');
    }
});
