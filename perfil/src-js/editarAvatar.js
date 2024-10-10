document.getElementById('redirigirPerfil').addEventListener('click', function(){
    window.location.href = "/perfil/perfil.html";
});

// let selectedAvatar = null;
// let clickCount = 0;

// // Cargar avatar desde localStorage al iniciar
// function loadAvatarFromLocalStorage() {
//     const savedAvatar = localStorage.getItem('selectedAvatar');
//     if (savedAvatar) {
//         const avatarDisplay = document.querySelector('.avatarvoid');
//         avatarDisplay.style.backgroundImage = `url(${savedAvatar})`;
//         avatarDisplay.style.backgroundSize = 'cover';
//         avatarDisplay.style.width = '10vw';
//         avatarDisplay.style.height = '10vw';
//         selectedAvatar = savedAvatar;
//     }
// }

// // Almacenar avatar en localStorage
// function saveAvatarToLocalStorage(avatar) {
//     localStorage.setItem('selectedAvatar', avatar);
// }

// window.onload = loadAvatarFromLocalStorage;

// function selectAvatar(img) {
//     clickCount++;

//     // Si se hace clic dos veces sobre la misma imagen
//     if (selectedAvatar === img.src && clickCount === 2) {
//         selectedAvatar = null;
//         const avatarDisplay = document.querySelector('.avatarvoid');
//         avatarDisplay.style.backgroundImage = 'url(/Generales/img/usuario.png)'; // Volver a mostrar el icono original
//         document.getElementById('selectBtn').textContent = 'Elegir Avatar'; // Restablecer texto del botón
//         localStorage.removeItem('selectedAvatar'); // Eliminar avatar del localStorage
//         clickCount = 0; // Reiniciar contador
//         return;
//     }

//     // Cambiar la imagen del avatar visualizado
//     const avatarDisplay = document.querySelector('.avatarvoid');
//     avatarDisplay.style.backgroundImage = `url(${img.src})`;
//     avatarDisplay.style.backgroundSize = 'cover';
//     avatarDisplay.style.width = '10vw';
//     avatarDisplay.style.height = '10vw';

//     // Eliminar cualquier candado existente
//     avatarDisplay.innerHTML = ''; 

//     // Cambiar el botón
//     const selectBtn = document.getElementById('selectBtn');
//     if (selectedAvatar === img.src) {
//         selectedAvatar = null;
//         selectBtn.textContent = 'Elegir Avatar';
//         avatarDisplay.style.backgroundImage = 'url(/Generales/img/usuario.png)';
//         localStorage.removeItem('selectedAvatar');
//     } else {
//         selectedAvatar = img.src;
//         selectBtn.textContent = 'Seleccionar Avatar';
//         saveAvatarToLocalStorage(selectedAvatar); 
//         selectBtn.style.width = '25vw';
//     }
// }

// function selectComprarAvatar(img) {
//     const avatarDisplay = document.querySelector('.avatarvoid');
//     const selectBtn = document.getElementById('selectBtn');

//     // Limpiar el contenido anterior del avatarvoid
//     avatarDisplay.innerHTML = '';

//     // Cambiar la imagen de fondo del avatarvoid
//     avatarDisplay.style.backgroundImage = `url(${img.src})`;
//     avatarDisplay.style.backgroundSize = 'cover';
//     avatarDisplay.style.position = 'relative';

//     // Crear y agregar el ícono de candado
//     const lockIcon = document.createElement('i');
//     lockIcon.classList.add('fa-solid', 'fa-lock');
//     lockIcon.style.position = 'absolute';
//     lockIcon.style.top = '50%';
//     lockIcon.style.left = '50%';
//     lockIcon.style.transform = 'translate(-50%, -50%)';
//     lockIcon.style.fontSize = '3vw';
//     lockIcon.style.color = 'rgba(0, 0, 0, 1)';

//     // Agregar el ícono al avatarvoid
//     avatarDisplay.appendChild(lockIcon);

//     // Cambiar el texto del botón a "Comprar este avatar"
//     selectBtn.textContent = 'Comprar este avatar';
//     selectBtn.style.width = '25vw';

// }

// document.querySelectorAll('.avatares.comprar').forEach(function(element) {
//     element.addEventListener('click', function() {
//         selectComprarAvatar(this);
//     });
// });

// document.getElementById('selectBtn').addEventListener('click', function() {
//     const avatarDisplay = document.querySelector('.avatarvoid');
//     const selectBtn = document.getElementById('selectBtn');

//     if (selectedAvatar) {
//         avatarDisplay.style.backgroundImage = `url(${selectedAvatar})`;
//         avatarDisplay.innerHTML = ''; // Elimina el candado si ya hay un avatar seleccionado
//         selectBtn.textContent = 'Avatar Seleccionado';
//         selectBtn.style.width = '25vw';
//         saveAvatarToLocalStorage(selectedAvatar); // Guardar en localStorage
//     } else {
//         selectBtn.textContent = 'Elegir Avatar';
//     }
// });

// Cargar avatares desde el JSON
fetch('/perfil/avatarComprar.json')
  .then(response => response.json())
  .then(data => {
    const avatarList = document.getElementById('avatarList');
    
    data.avatares.forEach(avatar => {
      // Crear un contenedor para cada avatar
      const avatarDiv = document.createElement('div');
      avatarDiv.classList.add('imagen-con-icono');
      avatarDiv.innerHTML = `<img src="${avatar.src}" alt="${avatar.alt}" class="${avatar.locked ? 'avatar' : 'avatar comprar'}">`;

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

  // Cambiar el texto del botón según si está bloqueado o no
  if (avatar.locked) {
    selectBtn.textContent = 'Comprar este avatar';
  } else {
    selectBtn.textContent = 'Avatar Seleccionado';
  }

  // Guardar avatar seleccionado en localStorage
  localStorage.setItem('selectedAvatar', JSON.stringify(avatar));

  // Manejar el clic en el botón de seleccionar/comprar
  selectBtn.onclick = () => {
    if (avatar.locked) {
      // Redirigir a la página de compra
      window.location.href = '/perfil/comprarAvatar.html';
    }
  };
}

