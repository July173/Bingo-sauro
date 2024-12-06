document.getElementById('redirigirJuego').addEventListener('click', async () => {
    // Obtener los valores de los campos
    const monedas = document.getElementById('monedasApostar').value;
    const cartones = document.getElementById('cartones').value;

    // Obtener el código de la partida desde localStorage
    const codigo = localStorage.getItem('codigoPartida');

    // Validar que ambos campos estén llenos y que el código esté presente
    if (!monedas || !cartones) {
        alert('Por favor, completa ambos campos antes de continuar.');
        return;
    }

    if (!codigo) {
        alert('Código de partida no encontrado. Intenta recargar la página.');
        return;
    }

    try {
        // Obtener las monedas mínimas y los cartones máximos desde el servidor
        const response = await fetch('./php/enviar_datos.php', { method: 'GET' });
        const restricciones = await response.json();

        const monedasMinimas = restricciones.monedas_minimas;
        const maximoCartones = restricciones.maximo_cartones;
        console.log(monedasMinimas);
        console.log(maximoCartones);

    
        // Validar que las monedas sean suficientes y los cartones no excedan el límite
        if (monedas < monedasMinimas) {
            alert(`La cantidad mínima de monedas para apostar es ${monedasMinimas}.`);
            return;
        }

        if (cartones > maximoCartones) {
            alert(`El número máximo de cartones es ${maximoCartones}.`);
            return;
        }

        // Enviar los datos al servidor, incluyendo el código de partida
        const serverResponse = await fetch('./php/enviar_datos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ monedas, cartones, codigo }), // Aquí se incluye el código
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
