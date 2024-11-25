(() => {
  "use strict";

  // Obtener todos los formularios que queremos validar
  const forms = document.querySelectorAll(".needs-validation");

  // Validación personalizada
  const validateCustom = (form) => {
    let valid = true;

    // Validación de la contraseña (mínimo 8 caracteres y un número)
    const password = document.getElementById("password");
    const passwordDos = document.getElementById("passwordDos");
    const passwordRegex = /^(?=.*[0-9]).{8,}$/; // Expresión regular para al menos 8 caracteres y un número

    // Validar la primera contraseña
    if (!passwordRegex.test(password.value)) {
      password.classList.add("is-invalid");
      valid = false;
    } else {
      password.classList.remove("is-invalid");
    }

    // Validar la segunda contraseña (que coincida con la primera)
    if (passwordDos.value !== password.value) {
      passwordDos.classList.add("is-invalid");
      valid = false;
    } else {
      passwordDos.classList.remove("is-invalid");
    }

    return valid;
  };
  // Mostrar u ocultar contraseñas
  const togglePasswordVisibility = (inputField, toggleButton) => {
    toggleButton.addEventListener("click", function () {
      const type = inputField.type === "password" ? "text" : "password";
      inputField.type = type;
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });
  };

  // Obtener referencias a los elementos de password y los ojitos
  const password = document.getElementById("password");
  const passwordDos = document.getElementById("passwordDos");
  const togglePassword = document.getElementById("togglePassword");
  const togglePasswordDos = document.getElementById("togglePasswordDos");

  // Aplicar la funcionalidad a ambos campos
  togglePasswordVisibility(password, togglePassword);
  togglePasswordVisibility(passwordDos, togglePasswordDos);

  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
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
        if (
          form.checkValidity() &&
          customValid &&
          form.id === "redirigirIniciar"
        ) {
          event.preventDefault(); // Evita la acción por defecto (no recargar la página)
          setTimeout(() => {
            window.location =
              "/Bingo-sauro/login/inicioSesion/InicioSesion.html"; // Redirige después de un retraso
          }, 1000); // Espera 1 segundo antes de redirigir
        }

        form.classList.add("was-validated"); // Aplica estilos de validación de Bootstrap
      },
      false
    );
  });
})();
