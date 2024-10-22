document.getElementById('redirigirPerfil').addEventListener('click', function(){
    window.location.href = "/perfil/editarAvatar.html";
});
// // nueva pantalla de compra
// window.onload = function() {
//     const avatarInfo = JSON.parse(localStorage.getItem('selectedAvatarInfo'));

//     if (avatarInfo) {
//         const avatarContainer = document.querySelector('.ContenedorAvatar');
//         const priceContainer = document.querySelector('.precio');

//         // Mostrar la imagen del avatar
//         const avatarImg = document.createElement('img');
//         avatarImg.src = avatarInfo.src;
//         avatarImg.alt = "Avatar a comprar";
//         avatarImg.style.width = '10vw'; // Ajusta según sea necesario
//         avatarImg.style.height = '10vw'; // Ajusta según sea necesario
//         avatarContainer.appendChild(avatarImg);

//         // Mostrar el precio del avatar
//         priceContainer.textContent = `Precio: $${avatarInfo.price}`;
//     }
// };

// Cargar avatar seleccionado desde localStorage
const selectedAvatar = JSON.parse(localStorage.getItem('selectedAvatar'));

if (selectedAvatar) {
  const avatarContainer = document.querySelector('.contenedorAvatar');
  const precioContainer = document.querySelector('.precio');
  
  avatarContainer.innerHTML = `<img src="${selectedAvatar.src}" alt="${selectedAvatar.alt}" class="avatar-imagen">`;
  precioContainer.innerHTML = `<span class="precio-texto">Precio: ${selectedAvatar.price}</span>`;

  // Manejar el clic en el botón de comprar
  document.getElementById('comprarBtn').addEventListener('click', () => {
    if (selectedAvatar.locked) {
      alert('Avatar comprado!');
      selectedAvatar.locked = false;
      localStorage.setItem('selectedAvatar', JSON.stringify(selectedAvatar));
      window.location.href = '/perfil/perfil.html';
    }
  });
}


