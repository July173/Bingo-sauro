  let cartonSeleccionado = null; // Variable global para el cartón seleccionado
  let botonSeleccionado = null; // Variable global para el botón seleccionado

  // Asegúrate de que el DOM esté completamente cargado antes de ejecutar el script
  document.addEventListener('DOMContentLoaded', function () {
    // Cargar cartones desde el archivo PHP
    fetch('./php/obtener_cartones.php')
      .then(response => response.json())
      .then(data => {
        const contenedorCartonesSala = document.getElementById('contenedorCartonesSala');
        let flechaVisible = null; // Variable para la flecha actualmente visible

        if (data.cartones && data.cartones.length > 0) {
          data.cartones.forEach(carton => {
            const cartonDiv = document.createElement('div');
            cartonDiv.classList.add('cartonn-sala');
            if (carton.locked) {
              cartonDiv.classList.add('locked'); // Añadir clase para estilos de bloqueado
            }

            const cartonImg = document.createElement('img');
            cartonImg.src = carton.src;
            cartonImg.alt = carton.alt;
            cartonImg.className = carton.locked ? 'carton comprar' : 'carton comprado';

            if (carton.locked) {
              const candado = document.createElement('i');
              candado.className = 'fa-solid fa-lock candado';
              cartonDiv.appendChild(candado);
            }

            const flecha = document.createElement('img');
            flecha.src = '../Generales/img/chulito.png';
            flecha.classList.add('flecha');
            flecha.style.display = 'none';

            if (carton.locked) {
              cartonDiv.addEventListener('click', () => {
                localStorage.setItem('selectedCarton', JSON.stringify(carton));
                window.location = `./carton_sala.php`;
              });
            } else {
              cartonImg.addEventListener('click', (event) => {
                event.stopPropagation();

                if (flechaVisible && flechaVisible !== flecha) {
                  flechaVisible.style.display = 'none';
                }

                flecha.style.display = flecha.style.display === 'none' ? 'block' : 'none';
                flechaVisible = flecha.style.display === 'block' ? flecha : null;
                cartonSeleccionado = flechaVisible ? carton : null;
              });
            }

            cartonDiv.appendChild(cartonImg);
            cartonDiv.appendChild(flecha);
            contenedorCartonesSala.appendChild(cartonDiv);
          });
        } else {
          contenedorCartonesSala.innerHTML = '<p>No hay cartones disponibles.</p>';
        }
      })
      .catch(error => console.error('Error al cargar los cartones:', error));

    // Validación para botones
    const botones = document.querySelectorAll('.botonJugador, .botonAdministrador');
    botones.forEach(boton => {
      boton.addEventListener('click', () => {
        botones.forEach(b => b.classList.remove('activo'));
        boton.classList.add('activo');
        botonSeleccionado = boton.classList.contains('botonJugador') ? 'jugador' : 'administrador';
      });
    });

    // Validaciones con el botón de iniciar
    const iniciarBtn = document.querySelector('.iniciar');
    iniciarBtn.addEventListener('click', function (event) {
      const monedasInput = document.querySelector('.numMonedasPorJugador');
      const cartonesInput = document.querySelector('.numCartonesPorJugador');

      if (!monedasInput.value.trim() || !cartonesInput.value.trim()) {
        event.preventDefault();
        alert('Debe llenar todos los espacios antes de iniciar la partida.');
        return;
      }

      if (!cartonSeleccionado || !botonSeleccionado) {
        event.preventDefault();
        alert('Debe seleccionar un cartón y un botón antes de iniciar la partida.');
        return;
      }

      console.log('Campos completos, partida iniciada.');
      console.log('Cartón seleccionado:', cartonSeleccionado, 'Botón seleccionado:', botonSeleccionado);
    });
  });

 // Evento para iniciar partida con datos enviados al servidor
document.querySelector('.iniciar').addEventListener('click', function (event) {
  const monedasInput = document.querySelector('.numMonedasPorJugador');
  const cartonesInput = document.querySelector('.numCartonesPorJugador');

  // Validaciones previas
  if (!monedasInput.value.trim() || !cartonesInput.value.trim()) {
    event.preventDefault();
    alert('Debe llenar todos los espacios antes de iniciar la partida.');
    return;
  }

  if (!cartonSeleccionado || !botonSeleccionado) {
    event.preventDefault();
    alert('Debe seleccionar un cartón y un botón antes de iniciar la partida.');
    return;
  }

  // Logs para verificar los datos
  console.log('Campos completos, partida iniciada.');
  console.log('Cartón seleccionado:', cartonSeleccionado.id);
  console.log('Botón seleccionado:', botonSeleccionado);
  console.log('Código de partida:', localStorage.getItem('codigoPartida'));

  // Enviar datos al servidor
  fetch('./php/iniciar_partida.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      monedasPorJugador: monedasInput.value,
      cartonesPorJugador: cartonesInput.value,
      cartonSeleccionado: cartonSeleccionado.id, // Asegúrate de que `cartonSeleccionado` tiene un id
      botonSeleccionado: botonSeleccionado,
      codigoPartida: localStorage.getItem('codigoPartida'),
    }),
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
      }
      return response.json(); // Esto convierte la respuesta a JSON
    })
    .then(data => {
      console.log('Respuesta del servidor (JSON):', data);

      if (data.success) {
        alert(data.message);

        if (botonSeleccionado === 'jugador') {
          window.location.href = '../juego_admi_jugador/juego-admi.php';
        } else if (botonSeleccionado === 'administrador') {
          window.location.href = '../juego_admi/juego-admi.php';
        }
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Error al iniciar partida:', error.message);
      alert('Error al procesar la respuesta del servidor.');
    });
});

