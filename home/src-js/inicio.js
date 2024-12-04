const boton = document.getElementById('miBotonn');

// Evento del botón
boton.addEventListener('click', async () => {

    try {
        const actualizado = await generarCodigoPartida(); // Ejecutar tu lógica principal

        if (actualizado) {
            // Redirigir si todo está bien
            window.location.href = "./../crear_sala/crearsala.php";
        } else {
            alert("No se pudo crear la sala. Inténtalo de nuevo.");
            console.log("Error al crear la sala.");
        }
    } catch (error) {
        console.error("Ocurrió un error:", error);
    }
});



const botonUnirme = document.getElementById('unirme');

botonUnirme.addEventListener('click', () => {
    window.location = './../unirme_sala/unirme.php';
});

const botonReclamar = document.getElementById('botonReclamarRecompensa');

botonReclamar.addEventListener('click', async () => {
    try {
        const response = await fetch('./php/recompensa_diaria.php'); // Asegúrate de que la ruta sea correcta
        const data = await response.json();
        alert(data.mensaje); // Mostrar el mensaje de la respuesta
        if (data.cantidad) {
            // Actualizar el saldo de monedas del usuario
            document.getElementById('monedas').innerText = `Saldo: ${data.cantidad}`;
        }
    } catch (error) {
        console.error('Error al reclamar la recompensa:', error);
    }
});
