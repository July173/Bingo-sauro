

// Mostrar el loader
function mostrarLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.style.display = 'flex'; // O 'block', según tu diseño
    }
}

// Ocultar el loader
function ocultarLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.style.display = 'none';
    }
}

 