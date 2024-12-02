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

// Llamar al archivo PHP para obtener el avatar seleccionado
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
      // Si no hay avatar seleccionado, mostrar un mensaje
      avatarVoid.innerHTML = "<p>No has seleccionado un avatar aún.</p>";
    }
  })
  .catch((error) => {
    console.error("Error al obtener el avatar:", error);
    avatarVoid.innerHTML = "<p>Error al cargar el avatar.</p>";
  });
