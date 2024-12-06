const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos


// Función para eliminar al amigo
function eliminarAmigo() {
  if (amigoAEliminar !== null) {
    amigosData = amigosData.filter(amigo => amigo.id !== amigoAEliminar); // Filtrar al amigo seleccionado
    mostrarAmigos(amigosData); // Actualizar la lista de amigos en la UI
    amigoAEliminar = null; // Reiniciar la variable
  }
}

let amigoIdToDelete;

function confirmarEliminacion(element) {
    amigoIdToDelete = element.getAttribute('data-id');
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

document.getElementById('confirmarEliminar').addEventListener('click', function() {
    eliminarAmigo(amigoIdToDelete);
});

function eliminarAmigo(amigoId) {
    fetch('./json/eliminar_amigo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ amigo_id: amigoId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Eliminar el amigo de la UI
            const amigoElemento = document.querySelector(`[data-id="${amigoId}"]`);
            if (amigoElemento) {
                amigoElemento.remove(); // Eliminar el elemento de la lista
            }

            // Cerrar el modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
            if (modal) {
                modal.hide(); // Cerrar el modal
            }
        } else {
            alert('Error: ' + data.error); // Mostrar el error
        }
    })
    .catch(error => console.error('Error:', error));
}
