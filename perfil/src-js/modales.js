document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Cargado - Iniciando script');

    const openModal2 = document.getElementById('openModal2');
    const yesBtn2 = document.getElementById('yesBtn2');
    const noBtn2 = document.getElementById('noBtn2');
    const modalElement = document.getElementById('questionModal2');

    if (!openModal2 || !yesBtn2 || !noBtn2 || !modalElement) {
        console.error('Error: No se encontraron todos los elementos necesarios');
        return;
    }

    try {
        const modal2 = new bootstrap.Modal(modalElement);

        openModal2.addEventListener('click', () => {
            console.log('Botón de contraseña clickeado');
            modal2.show();
        });

        yesBtn2.addEventListener('click', () => {
            console.log('Botón Sí clickeado');
            window.location.href = './editar-contraseña.php';
        });

        noBtn2.addEventListener('click', () => {
            console.log('Botón No clickeado');
            modal2.hide();
        });

    } catch (error) {
        console.error('Error al inicializar el modal:', error);
    }
});