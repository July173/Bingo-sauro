document
  .getElementById("redirigirPerfil")
  .addEventListener("click", function () {
    window.location = "./perfil.php";
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

// // Realizar la solicitud fetch para obtener los avatares filtrados por la categoría 1
// fetch('../../../Bingo-sauro/perfil/php/avatares.php', {
//     method: 'GET', // Usamos GET ya que el id_categoria ya está fijo en el PHP
//     headers: {
//         'Content-Type': 'application/json'
//     }
// })
// .then(response => {
//     // Verificar si la respuesta fue exitosa
//     if (!response.ok) {
//         throw new Error('Network response was not ok');
//     }
//     return response.json(); // Parsear la respuesta como JSON
// })
// .then(data => {
//     // Si la respuesta tiene éxito, mostrar los avatares
//     if (data.status === 'success') {
//         console.log('Avatares obtenidos:', data.data);

//         const avatarList = document.getElementById('avatarList');
//         avatarList.innerHTML = ''; // Limpiar la lista antes de agregar nuevos datos

//         // Iterar sobre los avatares obtenidos y crear los elementos HTML correspondientes
//         data.data.forEach(avatar => {
//             const avatarDiv = document.createElement('div');
//             avatarDiv.classList.add('imagen-con-icono');

//             // Si el avatar está bloqueado, agregar el icono de bloqueo
//             if (avatar.locked) {
//                 avatarDiv.innerHTML = `
//                     <div class="avatar-wrapper">
//                         <img src="${avatar.url}" alt="${avatar.nombre}" class="avatar comprar" data-url="${avatar.url}" data-locked="${avatar.locked}" />
//                         <i class="fa-solid fa-lock lock-icon"></i>
//                     </div>`;
//             } else {
//                 // Si el avatar no está bloqueado, solo mostrar la imagen
//                 avatarDiv.innerHTML = `
//                     <img src="${avatar.url}" alt="${avatar.nombre}" class="avatar comprado" data-url="${avatar.url}" data-locked="${avatar.locked}" />`;
//             }

//             // Añadir evento para seleccionar el avatar al hacer clic
//             avatarDiv.addEventListener('click', () => selectAvatar(avatar));
//             avatarList.appendChild(avatarDiv); // Añadir el avatar a la lista en el DOM
//         });
//     } else {
//         // Si no se pudo obtener los avatares, mostrar el mensaje de error
//         console.error('Error:', data.message);
//     }
// })
// .catch(error => {
//     // Manejar errores de la solicitud fetch
//     console.error('Hubo un problema con la solicitud fetch:', error);
// });

// // Función para manejar la selección de avatar
// function selectAvatar(avatar) {
//     const avatarDisplay = document.querySelector('.avatarvoid'); // Asegúrate de tener un contenedor con esta clase
//     const selectBtn = document.getElementById('selectBtn'); // El botón donde cambiará el texto

//     // Mostrar la imagen del avatar seleccionado
//     avatarDisplay.style.backgroundImage = `url(${avatar.url})`; // Usamos `avatar.url` para acceder a la URL de la imagen
//     avatarDisplay.style.backgroundSize = 'cover';
//     avatarDisplay.style.position = 'relative';

//     // Si está bloqueado, mostrar el botón "Comprar este avatar"
//     if (avatar.locked) {
//         selectBtn.textContent = 'Comprar este avatar';
//     } else {
//         // Si no está bloqueado, mostrar "Seleccionar avatar"
//         selectBtn.textContent = 'Seleccionar avatar';
//         selectBtn.style.width = '25vw'; // Ajusta el tamaño del botón si no está bloqueado
//     }
// }

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

// URL base para las peticiones al servidor
const baseUrl = "./php/avatares.php";

/**
 * Función para cargar todos los avatares disponibles y mostrarlos en el contenedor.
 */
function cargarAvatares() {
  fetch(`${baseUrl}?action=getAvatars`, {
    method: "GET",
    // headers: {
    //   "Content-Type": "application/json",
    // },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        mostrarAvatares(data.data); // Mostrar los avatares dinámicamente
      } else {
        console.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Error al obtener los avatares:", error);
    });
}

/**
 * Función para mostrar los avatares en el DOM.
 * @param {Array} avatares - Lista de avatares obtenida del servidor.
 */
// function mostrarAvatares(avatares) {
//   const container = document.getElementById("avatarContainer"); // Contenedor de los avatares
//   container.innerHTML = ""; // Limpiar el contenedor

//   avatares.forEach((avatar) => {
//     const avatarDiv = document.createElement("div");
//     avatarDiv.classList.add("avatar"); // Clase CSS para estilos
//     avatarDiv.setAttribute("data-id", avatar.id_articulo); // ID del avatar
//     avatarDiv.style.backgroundImage = `url(${avatar.url})`; // Imagen del avatar
//     avatarDiv.style.backgroundSize = "cover";

//     // // Evento al hacer clic en un avatar
//     // avatarDiv.addEventListener("click", () => {
//     //   selectAvatar(avatar); // Seleccionar el avatar
//     // });

//     container.appendChild(avatarDiv); // Agregar al contenedor
//   });
// }

function mostrarAvatares(avatares) {
  const container = document.getElementById("avatarContainer");

  // Verificar si el contenedor existe
  if (!container) {
    console.error("El contenedor 'avatarContainer' no existe.");
    return;
  }

  // Limpiar el contenedor
  container.innerHTML = "";

  avatares.forEach((avatar) => {
    const avatarDiv = document.createElement("div");
    avatarDiv.classList.add("avatar");
    avatarDiv.setAttribute("data-id", avatar.id_articulo);
    avatarDiv.style.backgroundImage = `url(${avatar.url})`;
    avatarDiv.style.backgroundSize = "cover";

    // Evento al hacer clic en un avatar
    avatarDiv.addEventListener("click", () => {
      selectAvatar(avatar); // Seleccionar el avatar
    });

    container.appendChild(avatarDiv);
  });
}
// /**
//  * Función para seleccionar un avatar.
//  * @param {Object} avatar - Avatar seleccionado.
//  */
// function selectAvatar(avatar) {
//   const idAvatarSeleccionado = avatar.id_articulo;

//   // Guardar el avatar seleccionado en la base de datos
//   guardarAvatarEnBD(idAvatarSeleccionado);

//   // Mostrar el avatar seleccionado en el cuadro principal
//   mostrarAvatarSeleccionado(avatar.url);
// }

// /**
//  * Función para guardar el avatar seleccionado en la base de datos.
//  * @param {number} idAvatarSeleccionado - ID del avatar seleccionado.
//  */
// function guardarAvatarEnBD(idAvatarSeleccionado) {
//   fetch(`${baseUrl}?action=updateAvatar`, {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/json",
//     },
//     body: JSON.stringify({ id_avatar: idAvatarSeleccionado }),
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.status === "success") {
//         console.log("Avatar actualizado correctamente.");
//       } else {
//         console.error(data.message);
//       }
//     })
//     .catch((error) => {
//       console.error("Error al actualizar el avatar:", error);
//     });

//   console.log(JSON.stringify({ id_avatar: idAvatarSeleccionado }));
// }

// /**
//  * Función para mostrar el avatar seleccionado en el área destacada.
//  * @param {string} avatarUrl - URL de la imagen del avatar seleccionado.
//  */
// function mostrarAvatarSeleccionado(avatarUrl) {
//   const avatarDisplay = document.querySelector(".avatarvoid"); // Área destacada

//   // Cambiar la imagen del avatar seleccionado
//   avatarDisplay.style.backgroundImage = `url(${avatarUrl})`;
//   avatarDisplay.style.backgroundSize = "cover";
// }

// /**
//  * Función para cargar el avatar seleccionado al cargar la página.
//  */
// function cargarAvatarSeleccionado() {
//   fetch(`${baseUrl}?action=getSelectedAvatar`)
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.status === "success") {
//         mostrarAvatarSeleccionado(data.avatar_url); // Mostrar el avatar seleccionado
//       } else {
//         console.error(data.message);
//       }
//     })
//     .catch((error) => {
//       console.error("Error al obtener el avatar seleccionado:", error);
//     });
// }

// Llamar a las funciones al cargar la página
cargarAvatares();
// cargarAvatarSeleccionado();
