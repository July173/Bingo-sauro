document.getElementById('redirigirCodigo').addEventListener('click', function(){
    window.location = "./perfil.php"
});

document.getElementById('formCambiarContraseña').addEventListener('submit', function(event) {
    event.preventDefault();

    const passwordActual = document.getElementById('password_actual').value.trim();
    const passwordNuevo = document.getElementById('password_nuevo').value.trim();
    const passwordConfirmar = document.getElementById('password_confirmar').value.trim();

    if (!passwordActual || !passwordNuevo || !passwordConfirmar) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Todos los campos son requeridos');
        return;
    }

    if (passwordNuevo.length < 8) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('La contraseña debe tener al menos 8 caracteres');
        return;
    }

    if (!/[0-9]/.test(passwordNuevo)) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('La contraseña debe contener al menos un número');
        return;
    }

    if (passwordNuevo !== passwordConfirmar) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Las contraseñas nuevas no coinciden');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('password_actual', passwordActual);
    formData.append('password_nuevo', passwordNuevo);
    formData.append('password_confirmar', passwordConfirmar);

    fetch('./php/procesar_cambio_contraseña.php', {
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
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
            setTimeout(() => {
                window.location.href = "../login/inicio-sesion/inicio-sesion.html";
            }, 1200);
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

// Funcionalidad para mostrar/ocultar contraseña
document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const inputElement = document.getElementById(targetId);
        
        // Cambiar el tipo de input
        if (inputElement.type === 'password') {
            inputElement.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            inputElement.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});