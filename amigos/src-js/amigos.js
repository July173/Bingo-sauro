const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos

// Simulamos cargar el archivo JSON
const amigosData = [
  {
    "id": 1,
    "imagen": "/Generales/img/avatar3.jpeg",
    "nombre": "Juan",
    "cantidad_premios": 5
  },
  {
    "id": 2,
    "imagen": "/Generales/img/avatarCuatro.jpeg",
    "nombre": "María",
    "cantidad_premios": 3
  },
  {
    "id": 3,
    "imagen": "/Generales/img/avatarDosGafas.jpeg",
    "nombre": "Carlos",
    "cantidad_premios": 7
  },
  {
    "id": 4,
    "imagen": "/Generales/img/avatarUnoRojo.jpeg",
    "nombre": "Lucía",
   "cantidad_premios": 2
    }
];

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
      <span  class="nombre-amigo">${amigo.nombre}</span>
      <div class="separador ranking fondo">
        <div class="counter counter-1" data-bs-toggle="modal" data-bs-target="#dinoModal">
          <span class="numero">${amigo.cantidad_premios}</span>
          <img src="/Generales/img/dinoTrofeos.png" alt="Dino">
        </div>
      </div>
    `;

    amigosDiv.appendChild(amigoDiv);
  });
}

// Llamada a la función con los datos simulados
mostrarAmigos(amigosData);
