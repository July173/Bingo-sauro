function cargarContenido() {
    fetch('http://localhost/Bingo-sauro/Generales/monedas/monedas.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('La respuesta de la red no fue ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('monedas').innerHTML = data;

            // Aplicar estilos después de cargar el contenido
            const modalElement = document.querySelector('.modal-content');
            if (modalElement) {
                modalElement.style.width = '17vw';
                modalElement.style.backgroundColor = '#FFF5D3';
                console.log('Estilos aplicados correctamente');
            } else {
                console.error('El modal no fue encontrado');
            }
        })
        .catch(error => console.error('Error al cargar el contenido:', error));
}
