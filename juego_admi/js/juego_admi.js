document.addEventListener('DOMContentLoaded', () => {
    const animations = [
        "https://lottie.host/27eeb06a-d46f-407e-a990-4e17e0cc2496/BFgVvTWKJv.json", // Primera animación
        "https://lottie.host/54e02410-09ee-45ff-8f6b-91f18d223fe4/WD2nnf03HC.json"  // Segunda animación
    ];

    const codigoPartida = localStorage.getItem('codigoPartida');

    // Función para cargar datos del servidor
    async function cargarDatos() {
        try {
            const response = await fetch(`./php/consultar_datos.php?codigo_sala=${codigoPartida}`, {
                method: 'GET', // Especifica el método GET explícitamente
            });

            if (!response.ok) {
                throw new Error('Error en la consulta: ' + response.status);
            }

            // Convierte la respuesta a JSON
            const datos = await response.json();

            // Verifica si hay un error en los datos
            if (datos.error) {
                alert("erro");
            } else {
                // Inserta los datos en el DOM
                document.getElementById('minimoMonedas').textContent = `Minimo de dino-monedas para apostar:, ${datos.monedas_minimas}!`;
                document.getElementById('cartonesMaximos').textContent = `Cantidad maxima de cartones: ${datos.maximo_cartones}`;
            }
        } catch (error) {
            console.error('Error al cargar los datos:', error);
        }
    }

    // Cargar el estado inicial de los cofres
    cargarDatos();
});