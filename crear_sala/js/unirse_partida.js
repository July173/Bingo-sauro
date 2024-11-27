
function unirseAPartida() {
    const codigo = document.getElementById("codigoEntrada").value;
    const nombre = document.getElementById("nombreJugador").value;
    // const foto = "ruta/a/la/foto.jpg"; // O selecciona la URL de la foto
  
    fetch(".php/unirse_partida.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `codigo=${codigo}&nombre=${nombre}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          agregarJugadorAlDOM(data.nombre, data.foto);
          document.getElementById('redirigirJuego').addEventListener('click', function(){
            window.location = "./../juego_usuario/juego-usuario.php"
        });
        
        } else {
          alert(data.error);
        }
      })
      .catch((error) => console.error("Error:", error));
  }
  
  function agregarJugadorAlDOM(nombre) {
    const contenedorJugadores = document.getElementById("contenedorJugadores");
    const jugadorDiv = document.createElement("div");
    jugadorDiv.classList.add("jugador");
    jugadorDiv.innerHTML = `< alt="${nombre}"><p>${nombre}</p>`;
    contenedorJugadores.appendChild(jugadorDiv);
  }