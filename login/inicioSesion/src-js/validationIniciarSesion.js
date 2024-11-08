(() => {
    'use strict';
  
    // Obtener todos los formularios que queremos validar
    const forms = document.querySelectorAll('.needs-validation');
  
    // Validación personalizada
    const validateCustom = (form) => {
        let valid = true;
  
        // Validación del correo
        const email = document.getElementById('email');
        if (!email.value) {
            email.classList.add('is-invalid');
            valid = false;
        } else {
            email.classList.remove('is-invalid');
        }
  
  
        // Validación de la contraseña (mínimo 8 caracteres y un número)
        const password = document.getElementById('password');
        const passwordRegex = /^(?=.*[0-9]).{8,}$/; // Expresión regular para al menos 8 caracteres y un número
        if (!passwordRegex.test(password.value)) {
            password.classList.add('is-invalid');
            valid = false;
        } else {
            password.classList.remove('is-invalid');
        }
  
        return valid;
    };
  
    // Loop sobre los formularios y aplicar validación personalizada y la de Bootstrap
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            // Validación nativa de Bootstrap
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } 
  
            // Validación personalizada
            const customValid = validateCustom(form);
  
            if (!customValid) {
                event.preventDefault();
                event.stopPropagation();
            }
  
            // Si el formulario es válido y tiene el id "redirigirIniciar", redirige
            if (form.checkValidity() && customValid && form.id === 'redirigirHome') {
                event.preventDefault(); // Evita la acción por defecto (no recargar la página)
                    window.location = "/Bingo-sauro/home/inicio.html"; // Redirige después de un retraso
                
            }
  
            form.classList.add('was-validated'); // Aplica estilos de validación de Bootstrap
        }, false);
    });
  })();
  
  const form = document.querySelector('form'); // Tu formulario
  const errorAnimation = document.getElementById('error-animation');
  
  form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) { // Si el formulario no es válido
          event.preventDefault(); // Evita el envío del formulario
          errorAnimation.style.display = 'block'; // Muestra la animación
      }
  });