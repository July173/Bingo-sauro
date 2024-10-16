// Recuperar el cartón seleccionado desde el localStorage
const selectedCarton = JSON.parse(localStorage.getItem('selectedCarton'));

// Verificar si existe un cartón seleccionado y mostrarlo
if (selectedCarton) {
  const contenedorSeleccionado = document.getElementById('contenedorCartonSeleccionado');

  // Crear un contenedor para mostrar el cartón seleccionado
  const cartonSeleccionadoDiv = document.createElement('div');
  cartonSeleccionadoDiv.classList.add('carton-item-seleccionado');
  cartonSeleccionadoDiv.innerHTML = `
    <div class="imagen-seleccionada-contenedor">
      <img src="${selectedCarton.src}" alt="${selectedCarton.alt}" class="carton-seleccionado">
    </div>
    <div class="precio-seleccionado-contenedor">
      <p>${selectedCarton.price}</p>
    </div>
  `;

  contenedorSeleccionado.appendChild(cartonSeleccionadoDiv);
} else {
  console.error('No se encontró ningún cartón seleccionado.');
}
