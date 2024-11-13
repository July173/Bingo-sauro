document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener los valores de los campos
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Validar que los campos no estén vacíos
    if (!email || !password) {
        alert('Por favor, complete todos los campos');
        return;
    }

    console.log('Datos a enviar:', { email, password }); // Para depuración

    const formData = new URLSearchParams();
    formData.append('correo', email);
    formData.append('contrasena', password);

    fetch('php/ingreso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data); // Para depuración

        if (data.validas) {
            window.location.href = "/Bingo-sauro/home/home.html";
        } else {
            document.getElementById('error-animation').style.display = 'block';
            alert(data.mensaje || 'Error en la validación');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-animation').style.display = 'block';
        alert('Error al intentar iniciar sesión');
    });
});

document.getElementById('redirigirRegistro').addEventListener('click', function(){
    window.location.href = "/Bingo-sauro/login/registro/registro.html"
});

document.getElementById('redirigirOlvidasteContra').addEventListener('click', function(){
    window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html"
});
