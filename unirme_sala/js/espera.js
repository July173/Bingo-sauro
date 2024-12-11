function verificarEstadoYUsuario() {
    const codigo = localStorage.getItem("codigoPartida");
    if (!codigo) {
        console.error("No se encontró el código de partida en LocalStorage.");
        alert("Código de partida no encontrado. Por favor, recarga la página.");
        return;
    }

    console.log("Código de partida antes del fetch:", codigo);

    fetch(`./php/verificar-estadia.php?codigoPartida=${codigo}`, {
        method: 'GET',
    })
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor.");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log(data.message);
                if (data.redirect) {
                    // Si la partida está iniciada, redirigir a la nueva página
                    window.location.href = "../juego_usuario/form-jugador.php";
                }
            } else {
                console.log(data.message || "Usuario no está en la partida.");
                alert(data.message || "Usuario no está en la partida.");
                
                window.location.href = "../home/inicio.php"; // Redirigir al inicio si no está en la partida
            }
        })
        .catch(error => {
            console.error("Error al verificar el estado o la participación:", error);
            alert("Error al verificar el estado o la participación.");
        });
}

// Ejecutar la verificación periódicamente
setInterval(verificarEstadoYUsuario, 5000);

