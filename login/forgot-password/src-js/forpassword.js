document.getElementById('redirigirIniciar').addEventListener('click', function(){
    window.location.href = "../inicio-sesion/inicio-sesion.html"
});

const form = document.getElementById('forgotPasswordForm');

if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        console.log('Email a guardar:', email);
        
        sessionStorage.setItem('reset_email', email);
        
        fetch('./php/enviar_codigo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${encodeURIComponent(email)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const savedEmail = sessionStorage.getItem('reset_email');
                console.log('Email guardado:', savedEmail);
                
                if (savedEmail) {
                    window.location.href = "../codigo-correo/contracodigo.html";
                } else {
                    alert('Error al guardar el email. Por favor, intenta nuevamente.');
                }
            } else {
                document.getElementById('error-animation').style.display = 'block';
                document.getElementById('ocultar').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('error-animation').style.display = 'block';
            document.getElementById('ocultar').style.display = 'none';
        });
    });
}
