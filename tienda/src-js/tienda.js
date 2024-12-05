// Cargar cartones desde el PHP
fetch('./php/carton.php')
  .then(response => response.json())
  .then(data => {
    // Contenedores para los cartones
    const contenedorCartones = document.getElementById('contenedorCartones');
    const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');

    // Variable para almacenar el cartón actualmente seleccionado
    let cartonSeleccionado = null;

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
      precioBoton.setAttribute('data-id', carton.id);

      if (carton.locked) {
        precioBoton.textContent = `${carton.price}`;
        precioBoton.classList.add('price-button');
        precioBoton.addEventListener('click', () => {
          localStorage.setItem('selectedCarton', JSON.stringify(carton));
          window.location = './comprar-carton.php';
        });
      } else {
        precioBoton.textContent = cartonSeleccionado === carton.id ? 'Seleccionado' : 'Seleccionar';
        precioBoton.classList.add('comprado-carton');
        if (cartonSeleccionado === carton.id) {
          precioBoton.classList.add('seleccionado'); // Agregar estilo si ya está seleccionado
        }
        precioBoton.addEventListener('click', () => {
          console.log(`Cartón seleccionado: ${carton.id}`);
          if (cartonSeleccionado !== carton.id) {
            cartonSeleccionado = carton.id;
            enviarCartonSeleccionado(carton.id); // Enviar el ID al servidor
            actualizarBotones(); // Actualizar todos los botones
          }
        });
        
      }

      cartonDiv.appendChild(precioBoton);
      contenedor.appendChild(cartonDiv);
    };

    // Función para actualizar los botones según el cartón seleccionado
    const actualizarBotones = () => {
      const botones = document.querySelectorAll('.comprado-carton');
      console.log('Botones encontrados:', botones.length);
            botones.forEach(boton => {
        const parentCarton = boton.getAttribute('data-id');
        if (parseInt(cartonSeleccionado) === parseInt(parentCarton)) {
          boton.textContent = 'Seleccionado';
          boton.classList.add('seleccionado');
        } else {
          boton.textContent = 'Seleccionar';
          boton.classList.remove('seleccionado');
        }
        
      });
    };
    

    // Función para enviar el cartón seleccionado al servidor
    const enviarCartonSeleccionado = (idCarton) => {
      fetch('./php/guardar-carton.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_carton: idCarton })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('Cartón guardado exitosamente');
          } else {
            console.error('Error al guardar el cartón:', data.error);
          }
        })
        .catch(error => console.error('Error al enviar el cartón:', error));
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
