// Función para obtener y mostrar las monedas restantes
function actualizarMonedas() {
    fetch('./../generales/monedas/php/obtener-monedas.php') // Cambia la ruta según tu estructura
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                const cuadroMonedas = document.getElementById('cuadro_monedas');
                if (cuadroMonedas) {
                    cuadroMonedas.textContent = data.monedas_restantes;
                } else {
                    console.error('No se encontró el elemento con ID "cuadro_monedas".');
                }
            } else {
                console.error('Error al obtener las monedas:', data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud de monedas:', error);
        });
}
// Actualizar cada 30 segundos
setInterval(actualizarMonedas, 30000);

// Llamar a la función al cargar la página
window.onload = actualizarMonedas;
