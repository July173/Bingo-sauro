
document.getElementById('redirigirPerfil').addEventListener('click', function () {
  window.location = "./editar-avatar.php";
});

// Cargar avatar seleccionado desde localStorage
window.onload = function () {
  const selectedAvatar = JSON.parse(localStorage.getItem('selectedAvatar'));

  if (selectedAvatar) {
    const avatarContainer = document.querySelector('.ContenedorAvatar'); // Asegúrate de que el selector tiene el punto
    const precioContainer = document.querySelector('.precio'); // Asegúrate de que el selector tiene el punto

    // Mostrar la imagen del avatar
    const avatarImg = document.createElement('img');
    avatarImg.src = selectedAvatar.src;
    avatarImg.alt = "Avatar a comprar";
    avatarImg.style.width = '25vw'; // Ajusta según sea necesario
    avatarImg.style.height = '25vw'; // Ajusta según sea necesario
    avatarImg.style.borderRadius = '3rem'
    avatarContainer.appendChild(avatarImg);

    // Mostrar el precio del avatar
    precioContainer.textContent = `${selectedAvatar.price}`;

    const priceIcon = document.createElement('img');
    priceIcon.src = '../generales/img/moneditas.png'; 
    priceIcon.style.width = '4vw'; // Ajusta el tamaño según sea necesario
    priceIcon.style.height = '4vw'; // Ajusta el tamaño según sea necesario
    priceIcon.style.marginLeft = '5px'; // Espaciado opcional entre el precio y la imagen

    // Agregar la imagen al contenedor de precio
    precioContainer.appendChild(priceIcon);

 
  } else {
    console.error('No hay avatar seleccionado en localStorage');
  }
}


// Función para realizar la compra
function comprarArticulo( idArticulo, precioArticulo) {
    console.log('Iniciando compra...');
    console.log('ID del artículo:', idArticulo);
    console.log('Precio del artículo:', precioArticulo);
    console.log('Datos enviados al servidor:', {
      idArticulo: idArticulo,
      precioArticulo: precioArticulo
  });
  
  // Hacer la solicitud AJAX a PHP
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
  .then(response => {
    console.log('Respuesta del servidor:', response);
    return response.json();
})  .then(data => {
  console.log('Datos recibidos del servidor:', data);
      // Verificar si la compra fue exitosa
      if (data.exito) {
          // Actualizar el cuadro de monedas con las monedas restantes
          console.log('Compra exitosa. Monedas restantes:', data.monedas_restantes);
          alert('Compra realizada con éxito. ¡Disfruta de tu artículo!');
      } else {
          // Si no fue exitosa, mostrar el mensaje de error
          console.error('Error en la compra:', data.mensaje);
          alert(data.mensaje);
      }
  })
  .catch(error => {
      console.error('Error en la compra:', error);
      alert('Hubo un error al procesar la compra.');
  });
}

// Evento cuando el usuario hace clic en el botón de compra
document.getElementById('comprarBtn').addEventListener('click', function() {
  const selectedAvatar = JSON.parse(localStorage.getItem('selectedAvatar'));

  if (!selectedAvatar) {
      console.error('No se encontró el avatar seleccionado en localStorage.');
      alert('No se encontró el avatar seleccionado.');
      return;
  }

  const idArticulo = selectedAvatar.id; // ID del artículo que se va a comprar
  const precioArticulo = selectedAvatar.price; // Precio del artículo

  console.log('ID del artículo seleccionado:', idArticulo);
  console.log('Precio del artículo seleccionado:', precioArticulo);

  // Llamar a la función de compra
  comprarArticulo(idArticulo, precioArticulo);
});