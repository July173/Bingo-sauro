(() => {
  'use strict';

  // Obtener todos los formularios que queremos validar
  const forms = document.querySelectorAll('.needs-validation');

  // Validación personalizada
  const validateCustom = (form) => {
      let valid = true;

      // Validación del nombre de usuario (mínimo 5 caracteres y no ofensivo)
      const username = document.getElementById('username');
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
          if (form.checkValidity() && customValid && form.id === 'redirigirIniciar') {
              event.preventDefault(); // Evita la acción por defecto (no recargar la página)
              setTimeout(() => {
                  window.location = "/Bingo-sauro/login/inicioSesion/InicioSesion.html"; // Redirige después de un retraso
              }, 1000); // Espera 1 segundo antes de redirigir
          }

          form.classList.add('was-validated'); // Aplica estilos de validación de Bootstrap
      }, false);
  });
})();