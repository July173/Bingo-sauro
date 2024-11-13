
 const botonn = document.getElementById('miBotonn');

botonn.addEventListener('click', () => {
    generarCodigoPartida();
    window.location.href = '../../../Bingo-sauro/Crearsala/crearsala.html';
});

const botonUnirme = document.getElementById('unirme');

botonUnirme.addEventListener('click', () => {
    window.location = '../../../Bingo-sauro/unirmeSala/unirme.html';
});
