
document.querySelector('#botonEnviar').addEventListener('click', () => {
    const monedasInput = document.querySelector('#monedasPorJugador');
    const cartonesInput = document.querySelector('#cartonesPorJugador');
    const cartonSeleccionado = "Cartón ejemplo"; // Cambia esto por tu lógica
    const botonSeleccionado = "Botón ejemplo"; // Cambia esto por tu lógica

    const data = {
        monedasPorJugador: monedasInput.value,
        cartonesPorJugador: cartonesInput.value,
        cartonSeleccionado,
        botonSeleccionado
    };

    console.log('Enviando datos:', data);

    fetch('validar_datos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) throw new Error('Error en la respuesta del servidor');
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.error) {
            alert(`Error: ${data.error}`);
        } else {
            alert('Datos enviados correctamente');
        }
    })
    .catch(error => {
        console.error('Error al enviar datos:', error);
    });
});
