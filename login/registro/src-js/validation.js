(() => {
  'use strict';

  // Obtener todos los formularios que queremos validar
  const forms = document.querySelectorAll('.needs-validation');

  // Validación personalizada
  const validateCustom = (form) => {
      let valid = true;

      // Validación del nombre de usuario (mínimo 5 caracteres y no ofensivo)
      const username = document.getElementById('primer_nombre');
      const offensiveWords = ['maldicion', 'palabraofensiva', 'putas', 'locas', 'perras']; // Lista de palabras ofensivas
      if (username.value.length < 5 || offensiveWords.some(word => username.value.toLowerCase().includes(word))) {
          username.classList.add('is-invalid');
          valid = false;
      } else {
          username.classList.remove('is-invalid');
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

      // Validación de campos vacíos
      const email = document.getElementById('email');
      if (!email.value || !username.value || !password.value) {
          email.classList.add('is-invalid');
          username.classList.add('is-invalid');
          password.classList.add('is-invalid');
          valid = false;
      } else {
          email.classList.remove('is-invalid');
          username.classList.remove('is-invalid');
          password.classList.remove('is-invalid');
      }

      return valid;
  };

  // Loop sobre los formularios y aplicar validación personalizada y la de Bootstrap
  Array.from(forms).forEach(form => {
      form.addEventListener('submit', async event => {
          event.preventDefault();
          
          // Validación nativa de Bootstrap
          if (!form.checkValidity()) {
              event.stopPropagation();
              form.classList.add('was-validated');
              return;
          }

          // Validación personalizada
          const customValid = validateCustom(form);
          if (!customValid) {
              event.stopPropagation();
              form.classList.add('was-validated');
              return;
          }

          // Si todas las validaciones pasan, enviar datos
          if (form.id === 'redirigirIniciar') {
              const formData = {
                  primer_nombre: document.getElementById('primer_nombre').value,
                  email: document.getElementById('email').value,
                  password: document.getElementById('password').value,
                  terminos_condiciones: document.getElementById('terminos_condiciones').value
              };

              try {
                  const response = await fetch('php/registro.php', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json'
                      },
                      body: JSON.stringify(formData)
                  });

                  const data = await response.json();

                  if (data.success) {
                      // Mostrar mensaje de éxito
                      alert('Registro exitoso');
                      // Redirigir después de 1 segundo
                      setTimeout(() => {
                        //   window.location.href = "../inicioSesion/InicioSesion.html";
                      }, 1000);
                  } else {
                      // Mostrar errores
                      alert(data.errors.join('\n'));
                  }
              } catch (error) {
                  console.error('Error:', error);
                  alert('Error al procesar el registro');
              }
          }

          form.classList.add('was-validated');
      }, false);
  });
})();