
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Página de verificación cargada');
    
    const email = sessionStorage.getItem('reset_email');
    console.log('📧 Email recuperado:', email);
    
    if (!email) {
        console.error('❌ No se encontró email en sessionStorage');
        alert('Por favor, inicia el proceso de recuperación nuevamente');
        window.location.href = "../forgot-password/forgotpassword.html"
        return;
    }
});

const inputs = document.querySelectorAll('.input-container input');

inputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        // Permitir solo números
        this.value = this.value.replace(/[^0-9]/g, '');
        
        if (this.value.length === 1) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        }
    });
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

document.getElementById('redirigirCambiar').addEventListener('click', function(e) {
    e.preventDefault();
    console.log('🔄 Iniciando verificación');
    
    const email = sessionStorage.getItem('reset_email');
    if (!email) {
        console.error('❌ Email no encontrado en sessionStorage');
        alert('Por favor, inicia el proceso de recuperación nuevamente');
        window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html";
        return;
    }

    // Obtener y validar el código
    let codigo = '';
    inputs.forEach(input => {
        codigo += input.value;
    });
    
    console.log('🔑 Código ingresado:', codigo);

    // Validar que el código tenga 5 dígitos
    if (codigo.length !== 5 || !/^\d{5}$/.test(codigo)) {
        console.error('❌ Código inválido o incompleto');
        alert('Por favor, ingrese un código válido de 5 dígitos');
        return;
    }

    // Enviar para verificación
    fetch('/Bingo-sauro/login/codigoCorreo/php/verificar_codigo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&codigo=${encodeURIComponent(codigo)}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('🔍 Respuesta del servidor:', data);
        
        if (data.success) {
            console.log('✅ Código verificado correctamente');
            sessionStorage.setItem('codigo_verificado', 'true');
            window.location.href = "/Bingo-sauro/login/CambiarPassword/cambiarContra.html";
        } else {
            console.error('❌ Verificación fallida:', data.message);
            alert('Código inválido. Por favor, verifique e intente nuevamente.');
            // Limpiar inputs
            inputs.forEach(input => {
                input.value = '';
            });
            inputs[0].focus();
        }
    })
    .catch(error => {
        console.error('🚫 Error en la verificación:', error);
        alert('Error al verificar el código');
    });
});

// Mantener el botón de regresar
document.getElementById('redirigirOlvidar').addEventListener('click', function(){
    window.location.href = "/Bingo-sauro/login/forgotPassword/forgotpassword.html";
});