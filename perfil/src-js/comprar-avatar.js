// Redirigir al perfil de edición de avatar
document.getElementById('redirigirPerfil').addEventListener('click', function () {
  window.location.href = "./editar-avatar.php";
});

// Cargar avatar seleccionado desde localStorage
// Ejecutar cuando el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM cargado correctamente.");

  try {
      const selectedAvatar = JSON.parse(localStorage.getItem('selectedAvatar'));

      if (!selectedAvatar) {
          console.error('No hay avatar seleccionado en localStorage.');
          return;
      }

      const avatarContainer = document.querySelector('.ContenedorAvatar');
      const precioContainer = document.querySelector('.precio');

      if (!avatarContainer || !precioContainer) {
          console.error('Elementos necesarios no encontrados en el DOM.');
          return;
      }

      const avatarImg = document.createElement('img');
      avatarImg.src = selectedAvatar.src;
      avatarImg.alt = "Avatar a comprar";
      avatarImg.style.width = '25vw';
      avatarImg.style.height = '25vw';
      avatarImg.style.borderRadius = '3rem';

      function adjustAvatarSize() {
        const isPortrait = window.matchMedia('(orientation: portrait)').matches;
      
        if (isPortrait) {
          avatarImg.style.width = '80vw'; // Ajustes para modo portrait
          avatarImg.style.height = '80vw';
          avatarImg.style.marginTop = '30vw';
          
        } else {
          avatarImg.style.width = '28vw'; // Ajustes para modo landscape
          avatarImg.style.height = '28vw';
          
        }
      }
      
      // Escucha cambios en la orientación
      const mediaQueryList = window.matchMedia('(orientation: portrait)');
      mediaQueryList.addEventListener('change', adjustAvatarSize);
      
      // Llama a la función inicialmente para configurar los estilos
      adjustAvatarSize();

      avatarContainer.appendChild(avatarImg);
      precioContainer.textContent = `${selectedAvatar.price}`;

      const priceIcon = document.createElement('img');
      priceIcon.src = '../generales/img/moneditas.png';
      priceIcon.style.width = '4vw';
      priceIcon.style.height = '4vw';
      priceIcon.style.marginLeft = '5px';

      precioContainer.appendChild(priceIcon);
  } catch (error) {
      console.error('Error al cargar el avatar:', error);
  }
});


// Evento cuando el usuario hace clic en el botón de compra
document.addEventListener("DOMContentLoaded", function () {
    const comprarBtn = document.getElementById('comprarBtn');
    const selectedAvatar = JSON.parse(localStorage.getItem('selectedAvatar'));

    if (!selectedAvatar) {
        console.error('No se encontró el avatar seleccionado en localStorage.');
        alert('No se encontró el avatar seleccionado.');
        comprarBtn.disabled = true; // Deshabilitar botón si no hay avatar seleccionado
        return;
    }

    const idArticulo = selectedAvatar.id;

    // Verificar si el artículo ya fue comprado
    const articulosComprados = JSON.parse(localStorage.getItem('articulosComprados')) || {};
    if (articulosComprados[idArticulo]) {
        comprarBtn.textContent = 'Comprado';
        comprarBtn.disabled = true;
        comprarBtn.style.backgroundColor = '#ccc'; // Opcional: cambiar estilo del botón
        return;
    }

    // Agregar evento al botón de compra
    comprarBtn.addEventListener('click', function () {
        const precioArticulo = selectedAvatar.price;

        console.log('ID del artículo seleccionado:', idArticulo);
        console.log('Precio del artículo seleccionado:', precioArticulo);

        // Llamar a la función de compra
        comprarArticulo(idArticulo, precioArticulo, comprarBtn);
    });
});

// Función para realizar la compra
function comprarArticulo(idArticulo, precioArticulo, button) {
    console.log('Iniciando compra...');

    fetch('./php/compra.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idArticulo: idArticulo,
            precioArticulo: precioArticulo
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                console.log('Compra exitosa. Monedas restantes:', data.monedas_restantes);
                alert('Compra realizada con éxito. ¡Disfruta de tu artículo!');

                // Marcar el artículo como comprado
                const articulosComprados = JSON.parse(localStorage.getItem('articulosComprados')) || {};
                articulosComprados[idArticulo] = true;
                localStorage.setItem('articulosComprados', JSON.stringify(articulosComprados));

                // Actualizar el botón
                button.textContent = 'Comprado';
                button.disabled = true;
                button.style.backgroundColor = '#ccc'; // Opcional: cambiar estilo
            } else {
                console.error('Error en la compra:', data.mensaje);
                alert(data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la compra:', error);
            alert('Hubo un error al procesar la compra.');
        });
}
