// Cargar cartones desde el PHP
fetch('./php/carton.php')
  .then(response => response.json())
  .then(data => {
    // Contenedores para los cartones
    const contenedorCartones = document.getElementById('contenedorCartones');
    const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');

    // Función para crear y añadir un cartón
    const agregarCarton = (carton, contenedor) => {
      const cartonDiv = document.createElement('div');
      cartonDiv.classList.add('carton-item');

      if (carton.locked) {
        cartonDiv.innerHTML = `
          <div class="avatar-wrapper">
            <img src="${carton.src}" alt="${carton.alt}" class="carton comprar">
            <i class="fa-solid fa-lock candado"></i> <!-- Ícono de candado -->
          </div>`;
      } else {
        cartonDiv.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="carton comprado">`;
      }

      const precioBoton = document.createElement('button');
      if (carton.locked) {
        precioBoton.textContent = `${carton.price}`;
        precioBoton.classList.add('price-button');
        precioBoton.addEventListener('click', () => {
          localStorage.setItem('selectedCarton', JSON.stringify(carton));
          window.location = './comprar-carton.php';
        });
      } else {
        precioBoton.textContent = 'seleccionar';
        precioBoton.classList.add('comprado-carton');
      }

      cartonDiv.appendChild(precioBoton);
      contenedor.appendChild(cartonDiv);
    };

    // Agregar cartones al contenedor principal
    if (data.cartones && data.cartones.length > 0) {
      data.cartones.forEach(carton => {
        if (contenedorCartones) {
          agregarCarton(carton, contenedorCartones);
        }
        if (contenedorCartonesSala) {
          agregarCarton(carton, contenedorCartonesSala);
        }
      });
    } else {
      // Si no hay cartones, mostrar un mensaje
      if (contenedorCartones) {
        contenedorCartones.innerHTML = '<p>No hay cartones disponibles.</p>';
      }
      if (contenedorCartonesSala) {
        contenedorCartonesSala.innerHTML = '<p>No hay cartones disponibles.</p>';
      }
    }
  })
  .catch(error => console.error('Error al cargar los cartones:', error));
