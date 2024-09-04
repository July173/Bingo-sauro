function cambiarFondo() {
    document.body.classList.add('show-background');
    
    // Espera 3 segundos después del cambio de fondo para mostrar los elementos de gifts
    setTimeout(function() {
        document.body.classList.add('show-gifts');
    }, 2000);
}

// Cambiar el fondo después de 2 segundos (2000 ms)
setTimeout(cambiarFondo, 2000);