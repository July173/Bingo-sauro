const openModal = document.getElementById('openModal');
const yesBtn = document.getElementById('yesBtn');
const noBtn = document.getElementById('noBtn');
const modal = new bootstrap.Modal(document.getElementById('questionModal'));

// Abrir el modal al hacer clic en el ícono
openModal.addEventListener('click', () => {
    modal.show();
});