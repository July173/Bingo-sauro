// Cargar cartones desde el JSON
fetch('/tienda/comprarCarton.json')
  .then(response => response.json())
  .then(data => {
    const contenedorCartones = document.getElementById('contenedorCartones');
    
    data.cartones.forEach(carton => {
      // Crear un contenedor para cada carton
      const cartonDiv = document.createElement('div');
      cartonDiv.classList.add('carton-item');
      cartonDiv.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="${carton.locked ? 'carton' : 'carton comprar'}">`;

        const precioBoton = document.createElement('button');
        precioBoton.textContent = ` ${carton.price} `;
        precioBoton.classList.add('price-button');

      precioBoton.addEventListener('click', () => {
        localStorage.setItem('selectedCarton', JSON.stringify(carton));
        window.location.href = '/tienda/comprarCarton.html';
      });
      
      cartonDiv.appendChild(precioBoton);
      contenedorCartones.appendChild(cartonDiv);
    });
  })

  .catch(error => console.error('error al cargar los cartones',error));