document.addEventListener('DOMContentLoaded', () => {
    const codigoPartida = localStorage.getItem('codigoPartida'); // Código de sala almacenado

    // Función para cargar datos del servidor
    async function cargarDatos() {
        console.log("Cargando datos...");

        try {
            // Realizar la consulta al archivo PHP con el código de sala
            const response = await fetch(`./php/consulta.php?codigo_sala=${codigoPartida}`, {
                method: 'GET', // Método GET explícito
            });

            console.log("Consulta realizada.");

            // Verificar si la respuesta es válida
            if (!response.ok) {
                throw new Error('Error en la consulta: ' + response.status);
            }

            // Convertir la respuesta a JSON
            const datos = await response.json();

            // Manejo de errores del lado del servidor
            if (datos.error) {
                console.error('Error en los datos del servidor:', datos.error);
                alert('Error al cargar los datos: ' + datos.error);
                return;
            }

            // Mostrar los datos en el DOM
            console.log('Datos recibidos:', datos);

            // Actualizar la información en el DOM
            document.getElementById('monedasApostar').textContent = `Apostaste:  ${datos.monedas_apostar } dino-monedas`;
            document.getElementById('primerNombre').textContent = `Administrador: ${datos.primer_nombre}`;
        } catch (error) {
            console.error('Error al cargar los datos:', error);
        }
    }

    // Llamar a la función para cargar los datos
    if (codigoPartida) {
        cargarDatos();
    } else {
        console.error('No se encontró el código de sala en localStorage.');
    }
});
