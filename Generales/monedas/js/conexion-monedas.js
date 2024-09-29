function cargarContenido() {
    fetch('/Generales/monedas/index.html')
        .then(response => response.text())
        .then(data => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;

            // Insertar el contenido dinámico
            const contenidoInteresante = tempDiv.querySelector('#mostrar-esto').innerHTML;
            document.getElementById('contenido-cargado').innerHTML = contenidoInteresante;

            // Reinicializar el modal después de cargar el contenido
            const modalElement = document.getElementById('dinoModal');
            if (modalElement) {
                const modalInstance = new bootstrap.Modal(modalElement);
                console.log('Modal reinicializado correctamente');
            } else {
                console.error('El modal no fue encontrado');
            }
        })
        .catch(error => console.error('Error al cargar el contenido:', error));
}

window.onload = cargarContenido;
