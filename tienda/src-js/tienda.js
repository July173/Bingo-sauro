// Cargar cartones desde el JSON
fetch('../tienda/comprarCarton.json')
  .then(response => response.json())
  .then(data => {
    const contenedorCartones = document.getElementById('contenedorCartones');

    data.cartones.forEach(carton => {
      // Crear un contenedor para cada carton
      const cartonDiv = document.createElement('div');
      cartonDiv.classList.add('carton-item');

      if (carton.locked) {
        cartonDiv.innerHTML = `
         <div class="avatar-wrapper">
        <img src="${carton.src}" alt="${carton.alt}" class="carton comprar">`;
      }
      else {
        // Si no está bloqueado, solo mostrar la imagen
        cartonDiv.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="carton comprado">`;
      }

      const precioBoton = document.createElement('button');

      if (carton.locked) {
        precioBoton.textContent = ` ${carton.price} `;
        precioBoton.classList.add('price-button');
        precioBoton.addEventListener('click', () => {
          localStorage.setItem('selectedCarton', JSON.stringify(carton));
          window.location = '/Bingo-sauro/tienda/comprarCarton.html';
        });
      } else {
        precioBoton.textContent = `Carton comprado `;
        precioBoton.classList.add('comprado-carton');

      }

      cartonDiv.appendChild(precioBoton);
      contenedorCartones.appendChild(cartonDiv);
    });
  })

  .catch(error => console.error('error al cargar los cartones', error));