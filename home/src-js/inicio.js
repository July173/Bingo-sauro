
 const botonn = document.getElementById('miBotonn');

 // Evento del botón
botonn.addEventListener("click", async () => {
    const actualizado = await generarCodigoPartida(); // Esperar a que se complete

    if (actualizado) {
        // Redirigir solo si el código fue actualizado
        
            window.location.href = "../../../Bingo-sauro/Crearsala/crearsala.php";
       
    }else{
        alert("Pailassssssssss");
        console.log("paila")
    }
});


const botonUnirme = document.getElementById('unirme');

botonUnirme.addEventListener('click', () => {
    window.location = '../../../Bingo-sauro/unirmeSala/unirme.php';
});
