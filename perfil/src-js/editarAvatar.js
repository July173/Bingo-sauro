document.getElementById('redirigirPerfil').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/perfil.html";
});

// // Cargar avatares desde el JSON
// let selectedAvatar = null;
// let clickCount = 0;

// // Cargar avatar desde localStorage al iniciar
// function loadAvatarFromLocalStorage() {
//   const savedAvatar = localStorage.getItem('selectedAvatar');
//   if (savedAvatar) {
//     const avatarDisplay = document.querySelector('.avatarvoid');
//     avatarDisplay.style.backgroundImage = `url(${savedAvatar})`;
//     avatarDisplay.style.backgroundSize = 'cover';
//     avatarDisplay.style.width = '10vw';
//     avatarDisplay.style.height = '10vw';
//     selectedAvatar = savedAvatar;
//   }
// }

// window.onload = loadAvatarFromLocalStorage;

// // Cargar avatares desde el JSON
// fetch('../perfil/avatarComprar.json')
//   .then(response => response.json())
//   .then(data => {
//     const avatarList = document.getElementById('avatarList');
    
//     data.avatars.forEach(avatar => {
//       // Crear un contenedor para cada avatar
//       const avatarDiv = document.createElement('div');
//       avatarDiv.classList.add('imagen-con-icono');
//       avatarDiv.innerHTML = `<img src="${avatar.src}" alt="${avatar.alt}" class="${avatar.locked ? 'avatar comprar' : 'avatar comprado'}">`;

//       avatarDiv.addEventListener('click', () => selectAvatar(avatar));

//       avatarList.appendChild(avatarDiv);
//     });
//   });

// // Función para manejar la selección de avatar
// function selectAvatar(avatar) {
//   const avatarDisplay = document.querySelector('.avatarvoid');
//   const selectBtn = document.getElementById('selectBtn');
//   clickCount++;

//   // Si se hace clic dos veces sobre el mismo avatar
//   if (selectedAvatar === avatar.src && clickCount === 2) {
//     avatarDisplay.style.backgroundImage = 'url(/Generales/img/usuario.png)'; // Volver a la imagen de usuario original
//     selectBtn.textContent = 'Elegir Avatar';
//     selectedAvatar = null;
//     localStorage.removeItem('selectedAvatar');
//     clickCount = 0; // Reiniciar contador
//     return;
//   }

//   // Mostrar la imagen del avatar seleccionado
//   avatarDisplay.style.backgroundImage = `url(${avatar.src})`;
//   avatarDisplay.style.backgroundSize = 'cover';
//   avatarDisplay.style.position = 'relative';

//   // Cambiar el texto del botón según si está bloqueado o no
//   if (avatar.locked) {
//     selectBtn.textContent = 'Comprar este avatar';
//   } else {
//     selectBtn.textContent = 'Seleccionar Avatar';
//   }

//   // Guardar avatar seleccionado en localStorage al presionar el botón
//   selectBtn.onclick = () => {
//     if (!avatar.locked) {
//       selectedAvatar = avatar.src;
//       avatarDisplay.innerHTML = ''; // Elimina el candado si había uno
//       localStorage.setItem('selectedAvatar', avatar.src); // Guardar en localStorage
//       selectBtn.textContent = 'Avatar Seleccionado';
//     } else {
//       // Redirigir a la página de compra si está bloqueado
//       window.location = '/Bingo-sauro/perfil/comprarAvatar.html';
//     }
//   };
// }

// Cargar avatar desde localStorage al iniciar
function loadAvatarFromLocalStorage() {
  const savedAvatar = localStorage.getItem('selectedAvatar');
  if (savedAvatar) {
    const avatarDisplay = document.querySelector('.avatarvoid');
    avatarDisplay.style.backgroundImage = `url(${savedAvatar})`;
    avatarDisplay.style.backgroundSize = 'cover';
    avatarDisplay.style.width = '10vw';
    avatarDisplay.style.height = '10vw';
    selectedAvatar = savedAvatar;
  }
}

window.onload = loadAvatarFromLocalStorage;

fetch('../perfil/avatarComprar.json')
.then(response => response.json())
.then(data => {
  const avatarList = document.getElementById('avatarList');
  
  data.avatars.forEach(avatar => {
    // Crear un contenedor para cada avatar
    const avatarDiv = document.createElement('div');
    avatarDiv.classList.add('imagen-con-icono');
    
    // Verificar si el avatar está bloqueado
    if (avatar.locked) {
      // Si está bloqueado, agregar el ícono de candado
      avatarDiv.innerHTML = `
        <div class="avatar-wrapper">
          <img src="${avatar.src}" alt="${avatar.alt}" class="avatar comprar">
          <i class="fa-solid fa-lock lock-icon"></i>
        </div>`;
    } else {
      // Si no está bloqueado, solo mostrar la imagen
      avatarDiv.innerHTML = `<img src="${avatar.src}" alt="${avatar.alt}" class="avatar comprado">`;
    }

    avatarDiv.addEventListener('click', () => selectAvatar(avatar));

    avatarList.appendChild(avatarDiv);
  });
});

// Función para manejar la selección de avatar
function selectAvatar(avatar) {
const avatarDisplay = document.querySelector('.avatarvoid');
const selectBtn = document.getElementById('selectBtn');

// Mostrar la imagen del avatar seleccionado
avatarDisplay.style.backgroundImage = `url(${avatar.src})`;
avatarDisplay.style.backgroundSize = 'cover';
avatarDisplay.style.position = 'relative';

// Si está bloqueado, mostrar el botón "Comprar este avatar"
if (avatar.locked) {
  selectBtn.textContent = 'Comprar este avatar';
} else {
  // Si no está bloqueado, mostrar "Seleccionar avatar"
  selectBtn.textContent = 'Seleccionar avatar';
  selectBtn.style.width = '25vw';
}

// Guardar avatar seleccionado en localStorage
localStorage.setItem('selectedAvatar', JSON.stringify(avatar));

// Manejar el clic en el botón de seleccionar/comprar
selectBtn.onclick = () => {
  if (avatar.locked) {
    // Redirigir a la página de compra si el avatar está bloqueado
    window.location = '/Bingo-sauro/perfil/comprarAvatar.html';
  } else {
    // Si no está bloqueado, cambiar el texto del botón y guardar el avatar
    selectBtn.textContent = 'Avatar Seleccionado';
    localStorage.setItem('selectedAvatar', JSON.stringify(avatar));
    localStorage.setItem('selectedAvatar', avatar.src); // Guardar en localStorage

    // Aquí puedes añadir código para que el avatar aparezca en otra pantalla
  }
};

// Manejar doble clic en el mismo avatar para restaurar el avatarvoid original
avatarDisplay.addEventListener('dblclick', () => {
  avatarDisplay.style.backgroundImage = 'url(/ruta/a/avatar_void.png)'; // Cambia a la imagen original
  selectBtn.textContent = 'Seleccionar avatar';
});
}
