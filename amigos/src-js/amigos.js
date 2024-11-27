const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos

let amigosData = []; // Inicializar amigosData como un array vacío
let amigoAEliminar = null; // Variable para guardar el amigo a eliminar

// Función para cargar los amigos desde PHP
function cargarAmigos() {
  fetch('./json/amigos.php') // Ajusta la ruta según tu estructura de carpetas
    .then(response => {
      if (!response.ok) {
        throw new Error('Error en la respuesta de la red');
      }
      return response.json();
    })
    .then(data => {
      amigosData = data; // Asignar los datos cargados a amigosData
      mostrarAmigos(amigosData); // Mostrar amigos en la UI
    })
    .catch(error => console.error('Error al cargar el PHP:', error));
}

// Función para mostrar los amigos
function mostrarAmigos(amigos) {
  amigosDiv.innerHTML = ''; // Limpiar contenido previo
  if (amigos.length === 0) {
    amigosDiv.innerHTML = '<p class="mensaje-vacio">No hay aún amigos agregados.</p>';
    return;
  }

  amigos.forEach(amigo => {
    const amigoDiv = document.createElement('div');
    amigoDiv.classList.add('amigo'); // Clase para el estilo

    amigoDiv.innerHTML = `
      <img src="${amigo.imagen}" alt="Avatar de ${amigo.nombre}" class="avatar-imagen">
      <span class="nombre-amigo">${amigo.nombre}</span>
      <div class="separador ranking fondo mon">
        <div class="counter counter-1" data-bs-toggle="modal" data-bs-target="#dinoModal">
          <span class="numero">${amigo.cantidad_premios}</span>
          <img src="../generales/img/dinoTrofeos.png" alt="Dino">
        </div>
      </div>
    `;

    amigoDiv.addEventListener('click', () => abrirModal(amigo.id)); // Asociar evento al amigo
    amigosDiv.appendChild(amigoDiv);
  });
}

// Función para abrir el modal y almacenar el amigo seleccionado
function abrirModal(amigoId) {
  amigoAEliminar = amigoId; // Guardar el ID del amigo seleccionado
  const modal = new bootstrap.Modal(document.getElementById('questionModal'));
  modal.show();
}

// Función para eliminar al amigo
function eliminarAmigo() {
  if (amigoAEliminar !== null) {
    amigosData = amigosData.filter(amigo => amigo.id !== amigoAEliminar); // Filtrar al amigo seleccionado
    mostrarAmigos(amigosData); // Actualizar la lista de amigos en la UI

    // Aquí podrías agregar código para enviar la eliminación al servidor, si es necesario

    amigoAEliminar = null; // Reiniciar la variable
  }
}
// Asignar el evento al botón de confirmación de eliminación
document.getElementById('confirmarEliminacion').addEventListener('click', () => {
  eliminarAmigo();
  const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
  confirmModal.hide(); // Cerrar el modal de confirmación
});

// Llamada a la función para cargar amigos desde PHP porque asi debe de ser
cargarAmigos();
