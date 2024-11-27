const openModal = document.getElementById('openModal');
    const yesBtn = document.getElementById('yesBtn');
    const noBtn = document.getElementById('noBtn');
    const modal = new bootstrap.Modal(document.getElementById('questionModal'));

    // Abrir el modal al hacer clic en el ícono
    openModal.addEventListener('click', () => {
      modal.show();
    });

    // Redirigir a otra página si hace clic en "Sí"
    yesBtn.addEventListener('click', () => {
      window.location = './cambiar-correo.php'; // Cambia la URL según la página a la que quieras dirigir
    });

    // Cerrar el modal si hace clic en "No"
    noBtn.addEventListener('click', () => {
      modal.hide();
    });

    // Segundo modal
    const openModal2 = document.getElementById('openModal2');
    const yesBtn2 = document.getElementById('yesBtn2');
    const noBtn2 = document.getElementById('noBtn2');
    const modal2 = new bootstrap.Modal(document.getElementById('questionModal2'));

    openModal2.addEventListener('click', () => {
      modal2.show();
    });

    yesBtn2.addEventListener('click', () => {
      window.location = './editar-contraseña.php';
    });

    noBtn2.addEventListener('click', () => {
      modal2.hide();
    });