document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener los valores de los campos
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Obtener el logo
    const logo = document.querySelector('.logo'); // Obtener el logo

    // Validar que los campos no estén vacíos
    if (!email || !password) {
        document.getElementById('error-animation').style.display = 'block';
        logo.style.display = 'none'; // Ocultar el logo si hay error
        return; // Evitar la petición si los campos están vacíos
    }

    console.log('Datos a enviar:', { email, password }); // Para depuración

    const formData = new URLSearchParams();
    formData.append('correo', email);
    formData.append('contrasena', password);

    fetch('./php/ingreso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(async response => {
        console.log('Estado de la respuesta:', response.status);
        const text = await response.text();
        console.log('Respuesta raw:', text);
        
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Error al parsear JSON:', text);
            throw new Error('Respuesta inválida del servidor');
        }
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        
        if (data.validas) {
            // Verificar que data.usuario existe
            if (!data.usuario) {
                console.error('No hay datos de usuario en la respuesta');
                return;
            }

            // Guardar datos en localStorage
            const userData = {
                nombre: data.usuario.nombre,
                correo: data.usuario.correo,
                contrasena: data.usuario.contrasena
            };

            // Agregar logs de depuración
            console.log('Guardando datos en localStorage:', userData);
            localStorage.setItem('userData', JSON.stringify(userData));
            
            // Verificar que se guardó correctamente
            const savedData = localStorage.getItem('userData');
            console.log('Datos guardados en localStorage:', savedData);

            // Redirigir solo si los datos se guardaron
            if (savedData) {
                window.location.href = "../../home/inicio.php"; // Cambiar la URL de redirección según lo necesites
            }
        } else {
            // Ocultar la animación de error si estaba visible
            document.getElementById('error-animation').style.display = 'none';
            logo.style.display = 'block'; // Mostrar el logo si no hay errores

            if (data.mensaje === 'USUARIO_NO_VERIFICADO') {
                // Mostrar el modal usando Bootstrap 5
                const modalElement = document.getElementById('staticBackdrop');
                const modal = new bootstrap.Modal(modalElement, {});
                modal.show();
            } else if (data.mensaje === 'Usuario no encontrado') {
                document.getElementById('error-animation').style.display = 'block';
                logo.style.display = 'none'; // Ocultar el logo si el usuario no fue encontrado
                actualizarMensajeErrorCorreo('El correo no está registrado');
            } else {
                document.getElementById('error-animation').style.display = 'block';
                logo.style.display = 'none'; // Ocultar el logo si hay otro error
                actualizarMensajeErrorCorreo(data.mensaje);
            }
        }
    })
    .catch(error => {
        console.error('Error detallado:', error);
        document.getElementById('error-animation').style.display = 'block';
        logo.style.display = 'none'; // Ocultar el logo en caso de error
        actualizarMensajeErrorCorreo('Hubo un problema al procesar tu solicitud. Intenta de nuevo.');
    });
});

// Función para actualizar el mensaje de error relacionado con el correo
function actualizarMensajeErrorCorreo(mensaje) {
    const errorCorreo = document.getElementById('errorCorreo');
    if (errorCorreo) {
        errorCorreo.textContent = mensaje;
    }
}

// Redirigir al registro o a la recuperación de contraseña
document.getElementById('redirigirRegistro').addEventListener('click', function(){
    window.location.href = "../registro/registro.html";
});

document.getElementById('redirigirOlvidasteContra').addEventListener('click', function(){
    window.location.href = "../forgot-password/forgotpassword.html";
});
