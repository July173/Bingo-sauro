// Cargar cartones desde el JSON
fetch('../../../Bingo-sauro/Crearsala/cartonesSala.json')
  .then(response => response.json())
  .then(data => {
    const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');
    let flechaVisible = null; // Variable para almacenar la flecha actualmente visible
    let cartónSeleccionado = null; // Variable para almacenar el cartón seleccionado


    data.cartones.forEach(carton => {
      // Crear un contenedor para cada carton
      const cartonDiv = document.createElement('div');
      cartonDiv.classList.add('cartonn-sala');

      // Crear el elemento de imagen del cartón
      const cartonImg = document.createElement('img');
      cartonImg.src = carton.src;
      cartonImg.alt = carton.alt;
      cartonImg.className = carton.locked ? 'carton comprar' : 'carton comprado';

      // Crear el elemento de flecha (inicialmente oculto)
      const flecha = document.createElement('img');
      flecha.src = '../Generales/img/chulito.png'; // Cambia esto a la ruta de tu imagen de flecha
      flecha.classList.add('flecha');
      flecha.style.display = 'none'; // Ocultamos la flecha inicialmente

      // Añadir evento click para redirigir a otra pantalla
      cartonDiv.addEventListener('click', () => {
        localStorage.setItem('selectedCarton', JSON.stringify(carton));
        // Redirigir a la nueva pantalla
        window.location = `/Bingo-sauro/Crearsala/cartonSala.html`;
      });

      // Añadir evento click para mostrar la flecha si el cartón está bloqueado
      if (!carton.locked) {
        cartonImg.addEventListener('click', (event) => {
          event.stopPropagation(); // Evita que se active el evento de redirección

          // Ocultar la flecha actualmente visible, si existe
          if (flechaVisible && flechaVisible !== flecha) {
            flechaVisible.style.display = 'none';
          }

          // Mostrar la flecha sobre el cartón actual
          flecha.style.display = flecha.style.display === 'none' ? 'block' : 'none';
          
          // Actualizar la variable de flechaVisible
          flechaVisible = flecha.style.display === 'block' ? flecha : null;

          // Guardar la información del cartón seleccionado
          cartónSeleccionado = flechaVisible ? carton : null;
        });
      }

      // Añadir los elementos al contenedor del cartón
      cartonDiv.appendChild(cartonImg);
      cartonDiv.appendChild(flecha);

      // Agregar el contenedor del cartón al contenedor principal
      contenedorCartonesSala.appendChild(cartonDiv);
    });
  })
  .catch(error => console.error('Error al cargar los cartones:', error));

