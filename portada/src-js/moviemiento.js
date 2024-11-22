function cambiarFondo() {
    document.body.classList.add('show-background');
    
    // Espera 3 segundos después del cambio de fondo para mostrar los elementos de gifts
    setTimeout(function() {
        document.body.classList.add('show-gifts');
    }, 2000);
    
}

// Cambiar el fondo después de 2 segundos (2000 ms)
setTimeout(cambiarFondo, 2000);

function redirigirOtraPantalla() {
    window.location = "../Bingo-sauro/login/Bienvenido/pag2.html"; // Cambia  por el nombre de tu archivo HTML
}

// Redirigir después de 5 segundos (5000 milisegundos)
setTimeout(redirigirOtraPantalla, 10000);