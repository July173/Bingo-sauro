
 const botonn = document.getElementById('miBotonn');

 // Evento del botón
botonn.addEventListener("click", async () => {
    const actualizado = await generarCodigoPartida(); // Esperar a que se complete

    if (actualizado) {
        // Redirigir solo si el código fue actualizado
        setTimeout(() => {
            window.location.href = "../../../Bingo-sauro/Crearsala/crearsala.php";
        }, 2000); // Redirigir después de 3 segundos
    }else{
        alert("Pailassssssssss");
        console.log("paila")
    }
});


const botonUnirme = document.getElementById('unirme');

botonUnirme.addEventListener('click', () => {
    window.location = '../../../Bingo-sauro/unirmeSala/unirme.php';
});
