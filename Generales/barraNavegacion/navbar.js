function loadNavbar() {
    fetch('/Generales/barraNavegacion/navbar.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar-container').innerHTML = data;
  
        const columnas = document.querySelectorAll('.Columna');
  
        // Recuperar la columna seleccionada al cargar la página
        const columnaSeleccionada = localStorage.getItem('columnaSeleccionada');
        if (columnaSeleccionada) {
          document.getElementById(columnaSeleccionada).classList.add('cambiado');
        }
  
        columnas.forEach(columna => {
          columna.addEventListener('click', (event) => {
            // Cambia el color de la celda
            columnas.forEach(col => col.classList.remove('cambiado')); // Quita el color a todas
            event.target.classList.add('cambiado'); // Añade el color solo a la seleccionada
  
            // Guardar en localStorage la columna seleccionada
            localStorage.setItem('columnaSeleccionada', event.target.id);
  
            // Redirige a la URL correspondiente al id de la celda
            switch (event.target.id) {
             
                case 'inicio':
                    window.location.href = "/home/inicio.html";
                    break;
                    case 'historial':
                window.location.href = "/historial/historial.html";
                break;
              case 'amigos':
                window.location.href = "/amigos/amigos.html";
                break;
              case 'perfil':
                window.location.href = "/perfil/perfil.html";
                break;
              case 'tienda':
                window.location.href = "/tienda/tienda.html";
                break;
              default:
                break;
            }
          });
        });
      })
      .catch(error => console.error('Error al cargar la barra de navegación:', error));
  }