document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener los valores de los campos
    const nuevoNombre = document.getElementById('nuevo_nombre').value.trim();
    const confirmarNombre = document.getElementById('confirmar_nombre').value.trim();

    // Validar que los campos no estén vacíos
    if (!nuevoNombre || !confirmarNombre) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Todos los campos son requeridos');
        return;
    }

    // Validar longitud mínima
    if (nuevoNombre.length < 5) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('El nombre debe tener al menos 5 caracteres');
        return;
    }

    // Validar que los nombres coincidan
    if (nuevoNombre !== confirmarNombre) {
        document.getElementById('error-animation').style.display = 'block';
        mostrarError('Los nombres no coinciden');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('nuevo_nombre', nuevoNombre);
    formData.append('confirmar_nombre', confirmarNombre);

    fetch('./php/procesar_cambio_nombre.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        console.log('Respuesta del servidor:', text); // Para depuración
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Error al parsear JSON:', text);
            throw new Error('Respuesta inválida del servidor');
        }
    })
    .then(data => {
        if (data.success) {
            // Actualizar el nombre en localStorage si es necesario
            const userData = JSON.parse(localStorage.getItem('userData') || '{}');
            userData.nombre = nuevoNombre;
            localStorage.setItem('userData', JSON.stringify(userData));

            // Mostrar mensaje de éxito antes de redirigir
            alert('Nombre actualizado correctamente');
            
            // Redirigir al perfil después de un breve delay
            setTimeout(() => {
                window.location.href = "./perfil.php";
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

// Redirigir al perfil cuando se hace clic en el botón de cerrar
document.getElementById('redirigirPerfil').addEventListener('click', function() {
    window.location.href = "./perfil.php";
});

// Limpiar errores cuando el usuario comienza a escribir
document.querySelectorAll('.input').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const tooltip = this.nextElementSibling;
        if (tooltip && tooltip.classList.contains('invalid-tooltip')) {
            tooltip.textContent = 'El nombre de usuario debe tener al menos 5 caracteres y no ser ofensivo.';
        }
    });
});
