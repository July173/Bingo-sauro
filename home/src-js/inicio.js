
const boton = document.getElementById('miBotonn');

// Evento del botón
boton.addEventListener('click', async () => {
    mostrarLoader(); // Mostrar el loader

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
    } finally {
        ocultarLoader(); // Ocultar el loader al finalizar
    }
});



const botonUnirme = document.getElementById('unirme');

botonUnirme.addEventListener('click', () => {
    window.location = './../unirme_sala/unirme.php';
});
