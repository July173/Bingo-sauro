(() => {
    'use strict';

    // Obtener todos los formularios que queremos validar
    const forms = document.querySelectorAll('.needs-validation');

    // Validación personalizada
    const validateCustom = (form) => {
        let valid = true;

        // Validación del correo con estructura de correo real
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para un formato de correo válido
        if (!email.value || !emailRegex.test(email.value)) {
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

        // Validación de términos y condiciones
        const invalidCheck = document.getElementById('invalidCheck');
        if (!invalidCheck.checked) {
            invalidCheck.classList.add('is-invalid');
            valid = false;
        } else {
            invalidCheck.classList.remove('is-invalid');
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

            // Si el formulario es válido y tiene el id "redirigirHome", redirige
            if (form.checkValidity() && customValid && form.id === 'redirigirHome') {
                event.preventDefault(); // Evita la acción por defecto (no recargar la página)
                window.location = "../../home/inicio.php"; // Redirige después de un retraso
            }

            form.classList.add('was-validated'); // Aplica estilos de validación de Bootstrap
        }, false);
    });

    // Lógica adicional para el botón 'submitBtn'
    document.getElementById('submitBtn').addEventListener('click', async function (e) {
        e.preventDefault();

        const primer_nombre = document.getElementById('primer_nombre');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const invalidCheck = document.getElementById('invalidCheck');

        // Añadimos la validación de estructura de correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Lista de palabras ofensivas
        const offensiveWords = ['maldicion', 'palabraofensiva', 'putas', 'locas', 'perras'];
        let hasEmptyField = false;

        // Validación del nombre de usuario: mínimo 5 caracteres y sin palabras ofensivas
        if (primer_nombre.value.length < 5 || offensiveWords.some(word => primer_nombre.value.toLowerCase().includes(word))) {
            primer_nombre.classList.add('is-invalid');
            hasEmptyField = true;
        } else {
            primer_nombre.classList.remove('is-invalid');
        }

        // Modificamos la validación del email
        if (email.value === '' || !emailRegex.test(email.value)) {
            email.classList.add('is-invalid');
            hasEmptyField = true;
        } else {
            email.classList.remove('is-invalid');
        }

        // Modificamos la validación de la contraseña
        const passwordRegex = /^(?=.*[0-9]).{8,}$/;
        if (password.value === '' || !passwordRegex.test(password.value)) {
            password.classList.add('is-invalid');
            hasEmptyField = true;
        } else {
            password.classList.remove('is-invalid');
        }

        // Añadimos validación de términos y condiciones
        if (!invalidCheck.checked) {
            invalidCheck.classList.add('is-invalid');
            hasEmptyField = true;
        } else {
            invalidCheck.classList.remove('is-invalid');
        }

        // Si hay campos vacíos o inválidos, no continuar
        if (hasEmptyField) {
            // Obtener el logo y la animación de error
            const errorAnimation = document.getElementById('error-animation');
            const logo = document.querySelector('.logo'); // Cambiar a querySelector para obtener el logo

            // Mostrar la animación de error y ocultar el logo
            if (errorAnimation) {
                errorAnimation.style.display = 'block'; // Mostrar animación de error
                logo.style.display = 'none'; // Ocultar el logo
            }
            return;
        } else {
            // Si no hay errores, asegurarse de que el logo esté visible
            const logo = document.querySelector('.logo'); // Obtener el logo
            logo.style.display = 'block'; // Mostrar el logo si no hay errores
        }

        // Crear el objeto de datos a enviar si todos los campos están completos y válidos
        const data = {
            primer_nombre: primer_nombre.value,
            email: email.value,
            password: password.value
        };

        // Verificar qué datos se están enviando
        console.log("Datos que se están enviando:", data);

        fetch('./php/registro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const text = await response.text();
            try {
                const jsonResponse = JSON.parse(text);
                console.log("Respuesta del servidor:", jsonResponse);
                return jsonResponse;
            } catch (e) {
                console.error('Respuesta no válida del servidor:', text);
                throw new Error('Respuesta del servidor no válida');
            }
        })
        .then(data => {
            if (data.success) {
                // Redirigir a la página de carga
                window.location.href = "../../generales/loader/loader.html"; // Cambia la ruta según tu estructura 
            } else {
                console.error("Errores:", data.errors);
                alert(data.errors ? data.errors.join('\n') : 'Error en el registro');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al procesar el registro. Por favor, intente más tarde.');
        });
    });

    document.getElementById('redirigirIniciar').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        const formData = new FormData(this);
        fetch('php/test_mail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al enviar el correo. Por favor, intenta más tarde.');
        });
    });
})();
