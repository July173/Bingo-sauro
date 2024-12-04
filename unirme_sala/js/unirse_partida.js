function unirseAPartida() {
    const codigo = document.getElementById('codigo').value;

    // Validar si el código está vacío
    if (!codigo) {
        alert("Por favor ingresa un código de partida.");
        return;
    }

    fetch('./php/unirse_partida.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `codigo=${encodeURIComponent(codigo)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir a otra pantalla
            window.location.href = '../juego_usuario/juego-usuario.php'; // Cambia a la URL deseada
        } else {
            // Mostrar el error al usuario
            alert(data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}
