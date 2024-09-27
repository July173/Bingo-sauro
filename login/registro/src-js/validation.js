// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

const form = document.querySelector("form"); // Tu formulario
const errorAnimation = document.getElementById("error-animation");

form.addEventListener("submit", function (event) {
  if (!form.checkValidity()) {
    // Si el formulario no es válido
    event.preventDefault(); // Evita el envío del formulario
    errorAnimation.style.display = "block"; // Muestra la animación
  }
});
