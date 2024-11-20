document.getElementById('redirigirPerfil').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/perfil.php"
});

document.getElementById('formCambiarCorreo').addEventListener('submit', function(event) {
    event.preventDefault();

    const nuevoCorreo = document.getElementById('nuevo_correo').value.trim();
    const confirmarCorreo = document.getElementById('confirmar_correo').value.trim();

    if (!nuevoCorreo || !confirmarCorreo) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Todos los campos son requeridos');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(nuevoCorreo)) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('El formato del correo electrónico no es válido');
        return;
    }

    if (nuevoCorreo !== confirmarCorreo) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Los correos no coinciden');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('nuevo_correo', nuevoCorreo);
    formData.append('confirmar_correo', confirmarCorreo);

    fetch('/Bingo-sauro/perfil/php/procesar_cambio_correo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        console.log('Respuesta del servidor:', text);
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Error al parsear JSON:', text);
            throw new Error('Respuesta inválida del servidor');
        }
    })
    .then(data => {
        if (data.success) {
            alert('Correo actualizado correctamente');
            
            setTimeout(() => {
                window.location.href = "/Bingo-sauro/login/inicioSesion/InicioSesion.html";
            }, 1000);
        } else {
            document.getElementById('error-animation').style.display = 'block';
            mostrarError(data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Hubo un problema al procesar tu solicitud. Intenta de nuevo.');
    });
});

function mostrarError(mensaje) {
    const inputs = document.querySelectorAll('.input');
    inputs.forEach(input => {
        input.classList.add('is-invalid');
        const tooltip = input.nextElementSibling;
        if (tooltip && tooltip.classList.contains('invalid-tooltip')) {
            tooltip.textContent = mensaje;
        }
    });
}

document.querySelectorAll('.input').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const tooltip = this.nextElementSibling;
        if (tooltip && tooltip.classList.contains('invalid-tooltip')) {
            tooltip.textContent = this.getAttribute('data-original-message') || 'Por favor completa este campo';
        }
    });
});