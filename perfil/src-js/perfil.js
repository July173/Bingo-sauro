console.log('Contenido actual de localStorage:', {
    userData: localStorage.getItem('userData'),
    parsed: localStorage.getItem('userData') ? JSON.parse(localStorage.getItem('userData')) : null
});

document.getElementById('cambiarNombre').addEventListener('click', function(){
    window.location = "./cambiar-nombre.php"
});

document.getElementById('CambiarAvatar').addEventListener('click', function(){
    window.location = "./editar-avatar.php"
});

// Función para cargar el avatar
function loadAvatarFromLocalStorage() {
    const savedAvatar = localStorage.getItem('selectedAvatar');
    if (savedAvatar) {
        const avatarDisplay = document.getElementById('avatarDisplay');
        avatarDisplay.style.backgroundImage = `url(${savedAvatar})`;
        avatarDisplay.style.backgroundSize = 'cover';
        avatarDisplay.style.width = '10vw';
        avatarDisplay.style.height = '10vw';
    } else {
        const avatarDisplay = document.getElementById('avatarDisplay');
        avatarDisplay.style.backgroundSize = 'contain';
        avatarDisplay.style.backgroundRepeat = 'no-repeat';
        avatarDisplay.style.backgroundPosition = 'center';
        avatarDisplay.style.width = '10vw';
        avatarDisplay.style.height = '10vw';
    }
}

window.onload = function() {
    loadAvatarFromLocalStorage();
};

window.addEventListener('storage', function(event) {
    if (event.key === 'selectedAvatar') {
        loadAvatarFromLocalStorage();
    }
});