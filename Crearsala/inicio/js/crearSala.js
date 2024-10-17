// Cargar cartones desde el JSON
fetch('/Crearsala/inicio/cartonesSala.json')
  .then(response => response.json())
  .then(data => {
    const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');
    
    data.cartones.forEach(carton => {
      // Crear un contenedor para cada carton
      const cartonDiv = document.createElement('div');
      cartonDiv.classList.add('cartonn-sala');

      // Añadir el evento de click para redirigir a otra pantalla
      cartonDiv.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="${carton.locked ? 'carton' : 'carton comprar'}">`;
      cartonDiv.addEventListener('click', () => {
        // Redirigir a la nueva pantalla
        window.location.href = `/Crearsala/inicio/cartonSala.html?id=${carton.id}`;
      });
      
      contenedorCartonesSala.appendChild(cartonDiv);
    });
  })
  .catch(error => console.error('error al cargar los cartones', error));
