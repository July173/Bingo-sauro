// Función para alternar la visibilidad de la contraseña
function togglePasswordVisibility(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    } else {
        input.type = 'password';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Página de cambio de contraseña cargada');
    
    const email = sessionStorage.getItem('reset_email');
    console.log('📧 Email recuperado:', email);
    
    if (!email) {
        console.error('❌ No se encontró email en sessionStorage');
        alert('Por favor, inicia el proceso de recuperación nuevamente');
        window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html";
        return;
    }

    // Botón de cerrar
    document.getElementById('redirigirOlvidar').addEventListener('click', function() {
        window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html";
    });

    // Toggle para la nueva contraseña
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            togglePasswordVisibility('nuevaContrasena', 'togglePassword');
        });
    }

    // Toggle para confirmar contraseña
    const togglePasswordDos = document.getElementById('togglePasswordDos');
    if (togglePasswordDos) {
        togglePasswordDos.addEventListener('click', function() {
            togglePasswordVisibility('confirmarContrasena', 'togglePasswordDos');
        });
    }
});

// El formulario mantiene tus validaciones existentes
document.getElementById('cambiarContrasenaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('🔄 Iniciando cambio de contraseña');
    
    const nuevaContrasena = document.getElementById('nuevaContrasena').value;
    const confirmarContrasena = document.getElementById('confirmarContrasena').value;
    const email = sessionStorage.getItem('reset_email');
    
    // Validaciones
    if (nuevaContrasena.length < 8) {
        document.getElementById('error-animation').style.display = 'block';
        document.getElementById('ocultar').style.display = 'none';
        return;
    }
    
    if (nuevaContrasena !== confirmarContrasena) {
        document.getElementById('error-animation').style.display = 'block';
        document.getElementById('ocultar').style.display = 'none';
        return;
    }
    
    fetch('/Bingo-sauro/login/CambiarPassword/php/actualizar_contrasena.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&contrasena=${encodeURIComponent(nuevaContrasena)}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('🔍 Respuesta del servidor:', data);
        
        if (data.success) {
            console.log('✅ Contraseña actualizada correctamente');
            sessionStorage.removeItem('reset_email');
            window.location.href = "/Bingo-sauro/login/inicioSesion/InicioSesion.html";
        } else {
            console.error('❌ Error:', data.message);
            document.getElementById('error-animation').style.display = 'block';
            document.getElementById('ocultar').style.display = 'none';
        }
    })
    .catch(error => {
        console.error('🚫 Error:', error);
        document.getElementById('error-animation').style.display = 'block';
        document.getElementById('ocultar').style.display = 'none';
    });
});

