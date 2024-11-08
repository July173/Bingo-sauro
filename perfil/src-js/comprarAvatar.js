
document.getElementById('redirigirPerfil').addEventListener('click', function () {
  window.location = "/Bingo-sauro/perfil/editarAvatar.html";
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
    priceIcon.src = '../Generales/img/moneditas.png'; 
    priceIcon.style.width = '4vw'; // Ajusta el tamaño según sea necesario
    priceIcon.style.height = '4vw'; // Ajusta el tamaño según sea necesario
    priceIcon.style.marginLeft = '5px'; // Espaciado opcional entre el precio y la imagen

    // Agregar la imagen al contenedor de precio
    precioContainer.appendChild(priceIcon);

    // Manejar el clic en el botón de comprar
    document.getElementById('comprarBtn').addEventListener('click', () => {
      if (selectedAvatar.locked) {
        alert('Avatar comprado!');
        selectedAvatar.locked = false;
        localStorage.setItem('selectedAvatar', JSON.stringify(selectedAvatar));
        window.location = '/Bingo-sauro/perfil/perfil.html';
      }
    });
  } else {
    console.error('No hay avatar seleccionado en localStorage');
  }
}
