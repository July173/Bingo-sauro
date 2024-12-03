console.log('Contenido actual de localStorage:', {
    userData: localStorage.getItem('userData'),
    parsed: localStorage.getItem('userData') ? JSON.parse(localStorage.getItem('userData')) : null
});

document.getElementById('cambiarNombre').addEventListener('click', function(){
    window.location = "./cambiar-nombre.php"
});

document.getElementById('CambiarAvatar').addEventListener('click', function(){
    window.location = "./editar-avatar.php"
});

fetch("./php/mostrar-avatar.php")
  .then((response) => response.json())
  .then((data) => {
    const avatarVoid = document.getElementById("avatarDisplay");

    // Verificar si hay un avatar seleccionado
    if (data.avatar) {
      // Mostrar el avatar seleccionado en el div
      avatarVoid.innerHTML = `
        <img src="${data.avatar.src}" alt="${data.avatar.alt}" class="avatarvoid">
      `;
    } else {
      // Si no hay avatar seleccionado, mostrar el div con estilos personalizados
      avatarVoid.innerHTML = `
        <div style="
          width: 10vw;
          height: 10vw;
          background-color: rgb(228, 226, 226);
          margin-top: 1.5vw;
          margin-bottom: 1vw;
          border-radius: 1rem;
          background-size: contain;
          background-repeat: no-repeat;
          background-position: center;
          background-image: url('./../Generales/img/usuario.png');
        "></div>
      `;
    }
  })
  .catch((error) => {
    console.error("Error al obtener el avatar:", error);
    avatarVoid.innerHTML = `
      <div style="
        width: 10vw;
        height: 10vw;
        background-color: rgb(228, 226, 226);
        margin-top: 1.5vw;
        margin-bottom: 1vw;
        border-radius: 1rem;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-image: url('./../Generales/img/usuario.png');
      "></div>
    `;
  });
