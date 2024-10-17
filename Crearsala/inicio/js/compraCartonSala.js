// Función para obtener el valor del parámetro 'id' de la URL
function getCartonIdFromUrl() {
  const params = new URLSearchParams(window.location.search);
  return params.get('id');
}

// Obtener el ID del cartón desde la URL
const cartonId = getCartonIdFromUrl();

// Cargar el archivo JSON y mostrar los detalles del cartón
fetch('/Crearsala/inicio/cartonesSala.json')
  .then(response => response.json())
  .then(data => {
    // Buscar el cartón correspondiente al ID
    const carton = data.cartones.find(c => c.id === parseInt(cartonId));

    if (carton) {
      // Mostrar los detalles del cartón en la página
      const detallesCartonDiv = document.getElementById('detallesCarton');

      detallesCartonDiv.innerHTML = `
        <div class="imagen-contenedor">
          <img src="${carton.src}" alt="${carton.alt}" class="imagen-carton">
        </div>
        <div class="precio-contenedor">
          <p>Precio: $${carton.price}</p>
        </div>
        <div class="boton-contenedor">
          <button class="boton-comprar">Comprar</button>
        </div>
      `;
    } else {
      console.error('Cartón no encontrado');
    }
  })
  .catch(error => console.error('Error al cargar los detalles del cartón', error));
