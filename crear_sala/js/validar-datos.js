// Asegúrate de que el DOM esté completamente cargado antes de agregar el evento
document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar el botón
    const iniciarBtn = document.querySelector('.iniciar');

    // Validar cuando se haga clic en el botón
    iniciarBtn.addEventListener('click', function (event) {
        // Seleccionar los inputs
        const monedasInput = document.querySelector('.numMonedasPorJugador');
        const cartonesInput = document.querySelector('.numCartonesPorJugador');

        // Verificar si están vacíos
        if (!monedasInput.value.trim() || !cartonesInput.value.trim()) {
            // Evitar que continúe la acción del botón
            event.preventDefault();

            // Mostrar mensaje de advertencia
            alert('Debe llenar todos los espacios antes de iniciar la partida.');
            return;
        }

        // Si los campos están completos
        console.log('Campos completos, partida iniciada.');
    });
});
