document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener los valores de los campos
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Validar que los campos no estén vacíos
    if (!email || !password) {
       
        return;
    }

    console.log('Datos a enviar:', { email, password }); // Para depuración

    const formData = new URLSearchParams();
    formData.append('correo', email);
    formData.append('contrasena', password);

    fetch('/Bingo-sauro/login/inicioSesion/php/ingreso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(async response => {
        console.log('Estado de la respuesta:', response.status);
        const text = await response.text(); // Primero obtener el texto
        console.log('Respuesta raw:', text); // Log de la respuesta cruda
        
        try {
            return JSON.parse(text); // Intentar parsear el JSON
        } catch (e) {
            console.error('Error al parsear JSON:', text);
            throw new Error('Respuesta inválida del servidor');
        }
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);

        if (data.validas) {
            window.location.href = "../../home/inicio.html";
        } else {
            document.getElementById('error-animation').style.display = 'block';
            alert(data.mensaje || 'Error en la validación');
        }
    })
    .catch(error => {
        console.error('Error detallado:', error);
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
