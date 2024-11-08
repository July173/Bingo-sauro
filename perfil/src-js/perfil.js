document.getElementById('cambiarNombre').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/cambiarNombre.html"
});

document.getElementById('CambiarAvatar').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/editarAvatar.html"
});

 // Recuperar avatar de localStorage
 function loadAvatarFromLocalStorage() {
    const savedAvatar = localStorage.getItem('selectedAvatar');
    if (savedAvatar) {
        const avatarDisplay = document.getElementById('avatarDisplay');
        avatarDisplay.style.backgroundImage = `url(${savedAvatar})`;
        avatarDisplay.style.backgroundSize = 'cover';
        avatarDisplay.style.width = '10vw'; // Mantener el ancho original
        avatarDisplay.style.height = '10vw'; // Mantener la altura original
    } else {
        // Si no hay avatar seleccionado, mostrar el avatar por defecto
        const avatarDisplay = document.getElementById('avatarDisplay');
        avatarDisplay.style.backgroundSize = 'contain';
        avatarDisplay.style.backgroundRepeat = 'no-repeat';
        avatarDisplay.style.backgroundPosition = 'center';
        avatarDisplay.style.width = '10vw';
        avatarDisplay.style.height = '10vw';
    }
}

// Cargar el avatar al cargar la página
window.onload = loadAvatarFromLocalStorage;

window.addEventListener('storage', function(event) {
    if (event.key === 'selectedAvatar') {
        loadAvatarFromLocalStorage(); // Actualizar el avatar cuando cambie
    }
});