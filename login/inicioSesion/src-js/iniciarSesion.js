document.getElementById('redirigirHome').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Llamada a la función para validar las credenciales en la base de datos
    validarCredenciales(email, password);
});

function validarCredenciales(email, password) {
    fetch('../php/ingreso.php', { // Cambia esta URL a la de tu API
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'correo': email,
            'contrasena': password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.validas) { // Suponiendo que tu API devuelve un objeto con una propiedad 'validas'
            // Redirigir a la página de inicio si las credenciales son válidas
            window.location.href = "../inicioSesion/InicioSesion.html"; // Cambia esto a la URL de tu página de inicio
        } else {
            // Mostrar un mensaje de error si las credenciales son incorrectas
            document.getElementById('error-animation').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Manejo de errores en caso de fallo en la llamada a la API
        document.getElementById('error-animation').style.display = 'block';
    });
}

document.getElementById('redirigirRegistro').addEventListener('click', function(){
    window.location.href = "/Bingo-sauro/login/registro/registro.html"
});

document.getElementById('redirigirOlvidasteContra').addEventListener('click', function(){
    window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html"
});
