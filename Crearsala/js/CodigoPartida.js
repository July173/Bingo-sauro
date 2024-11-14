// Función asíncrona para generar el código de la partida
async function generarCodigoPartida() {
  try {
      const response = await fetch("../../../Bingo-sauro/Crearsala/php/crear_codigo.php");
      
      if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data.success) {
          // Guardar el código en localStorage
          localStorage.setItem("codigoPartida", data.codigo_sala);

          console.log("El código se ha guardado correctamente:", data.codigo_sala);
          return true; // Indica que se generó correctamente
      } else {
          console.error("Error desde el servidor:", data.error);
          return false; // Indica que no se generó
      }
  } catch (error) {
      console.error("Error al generar el código:", error);
      return false;
  }
}





function unirseAPartida() {
  const codigo = document.getElementById("codigoEntrada").value;
  const nombre = document.getElementById("nombreJugador").value;
  const foto = "ruta/a/la/foto.jpg"; // O selecciona la URL de la foto

  fetch("/Crearsala/php/unirsePartida.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `codigo=${codigo}&nombre=${nombre}&foto=${foto}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        agregarJugadorAlDOM(data.nombre, data.foto);
      } else {
        alert(data.error);
      }
    })
    .catch((error) => console.error("Error:", error));
}

function agregarJugadorAlDOM(nombre, foto) {
  const contenedorJugadores = document.getElementById("contenedorJugadores");
  const jugadorDiv = document.createElement("div");
  jugadorDiv.classList.add("jugador");
  jugadorDiv.innerHTML = `<img src="${foto}" alt="${nombre}"><p>${nombre}</p>`;
  contenedorJugadores.appendChild(jugadorDiv);
}
