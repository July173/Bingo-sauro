const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos

let amigosData = [
  {
    "id": 1,
    "imagen": "../Generales/img/avatar3.jpeg",
    "nombre": "Juan",
    "cantidad_premios": 5
  },
  {
    "id": 2,
    "imagen": "../Generales/img/avatarCuatro.jpeg",
    "nombre": "María",
    "cantidad_premios": 3
  },
  {
    "id": 3,
    "imagen": "../Generales/img/avatarDosGafas.jpeg",
    "nombre": "Carlos",
    "cantidad_premios": 7
  },
  {
    "id": 4,
    "imagen": "../Generales/img/avatarUnoRojo.jpeg",
    "nombre": "Lucía",
    "cantidad_premios": 2
  }
];

let amigoAEliminar = null; // Variable para guardar el amigo a eliminar

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
      <div class="separador ranking fondo">
        <div class="counter counter-1" data-bs-toggle="modal" data-bs-target="#dinoModal">
          <span class="numero">${amigo.cantidad_premios}</span>
          <img src="../Generales/img/dinoTrofeos.png" alt="Dino">
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

   

    amigoAEliminar = null; // Reiniciar la variable
  }
}

// Asignar el evento al botón de confirmación de eliminación
document.getElementById('confirmarEliminacion').addEventListener('click', () => {
  eliminarAmigo();
  const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
  confirmModal.hide(); // Cerrar el modal de confirmación
});

// Llamada a la función con los datos simulados
mostrarAmigos(amigosData);

