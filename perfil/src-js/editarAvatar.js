document.getElementById('redirigirPerfil').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/perfil.php";
});


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

// Realizar la solicitud fetch para obtener los avatares filtrados por la categoría 1
fetch('../../../Bingo-sauro/perfil/php/avatares.php', {
  method: 'GET', // Usamos GET ya que el id_categoria ya está fijo en el PHP
  headers: {
      'Content-Type': 'application/json'
  }
})
.then(response => {
  // Verificar si la respuesta fue exitosa
  if (!response.ok) {
      throw new Error('Network response was not ok');
  }
  return response.json(); // Parsear la respuesta como JSON
})
.then(data => {
  // Si la respuesta tiene éxito, mostrar los avatares
  if (data.status === 'success') {
      console.log('Avatares obtenidos:', data.data);
      
      const avatarList = document.getElementById('avatarList');
      avatarList.innerHTML = ''; // Limpiar la lista antes de agregar nuevos datos
      
      // Iterar sobre los avatares obtenidos y crear los elementos HTML correspondientes
      data.data.forEach(avatar => {
          const avatarDiv = document.createElement('div');
          avatarDiv.classList.add('imagen-con-icono');
          
          // Si el avatar está bloqueado, agregar el icono de bloqueo
          if (avatar.locked) {
              avatarDiv.innerHTML = `
                  <div class="avatar-wrapper">
                      <img src="${avatar.url}" alt="${avatar.nombre}" class="avatar comprar">
                      <i class="fa-solid fa-lock lock-icon"></i>
                  </div>`;
          } else {
              // Si el avatar no está bloqueado, solo mostrar la imagen
              avatarDiv.innerHTML = `
                  <img src="${avatar.url}" alt="${avatar.nombre}" class="avatar comprado">`;
          }
          
          // Añadir evento para seleccionar el avatar al hacer clic
          avatarDiv.addEventListener('click', () => selectAvatar(avatar));
          avatarList.appendChild(avatarDiv); // Añadir el avatar a la lista en el DOM
      });
  } else {
      // Si no se pudo obtener los avatares, mostrar el mensaje de error
      console.error('Error:', data.message);
  }
})
.catch(error => {
  // Manejar errores de la solicitud fetch
  console.error('Hubo un problema con la solicitud fetch:', error);
});



// // Función para manejar la selección de avatar
// function selectAvatar(avatar) {
// const avatarDisplay = document.querySelector('.avatarvoid');
// const selectBtn = document.getElementById('selectBtn');

// // Mostrar la imagen del avatar seleccionado
// avatarDisplay.style.backgroundImage = `url(${avatar.src})`;
// avatarDisplay.style.backgroundSize = 'cover';
// avatarDisplay.style.position = 'relative';

// // Si está bloqueado, mostrar el botón "Comprar este avatar"
// if (avatar.locked) {
//   selectBtn.textContent = 'Comprar este avatar';
// } else {
//   // Si no está bloqueado, mostrar "Seleccionar avatar"
//   selectBtn.textContent = 'Seleccionar avatar';
//   selectBtn.style.width = '25vw';
// }

// // Guardar avatar seleccionado en localStorage
// localStorage.setItem('selectedAvatar', JSON.stringify(avatar));

// // Manejar el clic en el botón de seleccionar/comprar
// selectBtn.onclick = () => {
//   if (avatar.locked) {
//     // Redirigir a la página de compra si el avatar está bloqueado
//     window.location = '/Bingo-sauro/perfil/comprarAvatar.php';
//   } else {
//     // Si no está bloqueado, cambiar el texto del botón y guardar el avatar
//     selectBtn.textContent = 'Avatar Seleccionado';
//     localStorage.setItem('selectedAvatar', JSON.stringify(avatar));
//     localStorage.setItem('selectedAvatar', avatar.src); // Guardar en localStorage

//     // Aquí puedes añadir código para que el avatar aparezca en otra pantalla
//   }
// };

// // Manejar doble clic en el mismo avatar para restaurar el avatarvoid original
// avatarDisplay.addEventListener('dblclick', () => {
//   avatarDisplay.style.backgroundImage = 'url(/ruta/a/avatar_void.png)'; // Cambia a la imagen original
//   selectBtn.textContent = 'Seleccionar avatar';
// });
// }
