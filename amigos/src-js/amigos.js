const amigosDiv = document.getElementById('AmigosRegistro'); // Referencia al contenedor donde se mostrarán los amigos

// Simulamos cargar el archivo JSON
const amigosData = [
  { Nombres: 'Juanito' },
  { Nombres: 'Ana' },
  { Nombres: 'Luis' },
  { Nombres: 'Carlos' },
  { Nombres: 'Marta' },
  { Nombres: 'Sofia' }
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
      <span>${amigo.Nombres}</span>
    `;

    amigosDiv.appendChild(amigoDiv);
  });
}

// Llamada a la función con los datos simulados
mostrarAmigos(amigosData);
