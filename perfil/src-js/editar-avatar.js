document.getElementById('redirigirPerfil').addEventListener('click', function(){
  window.location = "./perfil.php"
});
fetch("./php/avatares.php")
  .then((response) => response.json())
  .then((data) => {
    const contenedorCartones = document.getElementById("avatarContainer");
    const avatarVoid = document.getElementById("avatarvoid"); // Contenedor para mostrar avatar seleccionado
    const selectBtn = document.getElementById("selectBtn"); // Botón para seleccionar o comprar

    // Función para crear y añadir un avatar
    const agregarCarton = (carton, contenedor) => {
      const cartonDiv = document.createElement("div");
      cartonDiv.classList.add("avatar");
      if (carton.locked) {
        cartonDiv.innerHTML = `
          <div class="avatar-wrapper">
            <img src="${carton.src}" alt="${carton.alt}" class="avatar comprar">
            <i class="fa-solid fa-lock candado"></i> <!-- Ícono de candado -->
          </div>`;
      } else {
        cartonDiv.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="avatar comprado">`;
      }

      // Agregar evento click para seleccionar avatar
      cartonDiv.addEventListener("click", () => {
        // Aquí actualizamos `avatarVoid` para que se muestre el avatar seleccionado
        avatarVoid.innerHTML = `<img src="${carton.src}" alt="${carton.alt}" class="avatar-seleccionado">`;

        // Cambiar el texto del botón según si el avatar está bloqueado
        selectBtn.textContent = carton.locked
          ? "Comprar avatar"
          : "Seleccionar avatar";

        // Evento para el botón de seleccionar/comprar avatar
        selectBtn.onclick = () => {
          if (carton.locked) {
            localStorage.setItem("selectedAvatar", JSON.stringify(carton));
            window.location = "./comprar-avatar.php";
          } else {
            localStorage.setItem("selectedAvatar", JSON.stringify(carton));
            alert("Avatar seleccionado correctamente.");
          }
        };
      });

      contenedor.appendChild(cartonDiv);
    };

    // Agregar los avatares al contenedor
    if (data.cartones && data.cartones.length > 0) {
      data.cartones.forEach((carton) => {
        if (contenedorCartones) agregarCarton(carton, contenedorCartones);
      });
    } else {
      if (contenedorCartones) {
        contenedorCartones.innerHTML = "<p>No hay avatares disponibles.</p>";
      }
    }
  })
  .catch((error) => console.error("Error al cargar los avatares:", error));
