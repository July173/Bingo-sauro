// Cargar cartones desde el archivo PHP
fetch('./php/obtener_cartones.php')
  .then(response => response.json())
  .then(data => {
    const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');
    let flechaVisible = null; // Variable para almacenar la flecha actualmente visible
    let cartónSeleccionado = null; // Variable para almacenar el cartón seleccionado

    // Verificar si la respuesta contiene los cartones
    if (data.cartones && data.cartones.length > 0) {
      data.cartones.forEach(carton => {
        // Crear un contenedor para cada cartón
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
          window.location = `./carton_sala.php`;
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
    } else {
      // Si no hay cartones, mostrar un mensaje o manejar el caso
      contenedorCartonesSala.innerHTML = '<p>No hay cartones disponibles.</p>';
    }
  })
  .catch(error => console.error('Error al cargar los cartones:', error));

// Variable para almacenar el botón seleccionado
let botonSeleccionado = null;

const botones = document.querySelectorAll('.botonJugador, .botonAdministrador');

botones.forEach(boton => {
  boton.addEventListener('click', () => {
    // Elimina la clase 'activo' de todos los botones
    botones.forEach(b => b.classList.remove('activo'));
    // Agrega la clase 'activo' solo al botón clicado
    boton.classList.add('activo');

    // Actualiza la variable con el botón seleccionado
    botonSeleccionado = boton.classList.contains('botonJugador') ? 'jugador' : 'administrador';

    verjugadorapostar();
  });
});

const verjugadorapostar = () => {
  const contenedorJugador = document.querySelector('.contenedorapostarjugador');
  
  if (botonSeleccionado === 'jugador') {
      contenedorJugador.classList.remove('hidden'); // Muestra los divs
  } else {
      contenedorJugador.classList.add('hidden'); // Oculta los divs
  }
};