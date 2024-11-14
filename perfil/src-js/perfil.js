console.log('Contenido actual de localStorage:', {
    userData: localStorage.getItem('userData'),
    parsed: localStorage.getItem('userData') ? JSON.parse(localStorage.getItem('userData')) : null
});

document.getElementById('cambiarNombre').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/cambiarNombre.html"
});

document.getElementById('CambiarAvatar').addEventListener('click', function(){
    window.location = "/Bingo-sauro/perfil/editarAvatar.html"
});

// Función para cargar datos del usuario
function cargarDatosUsuario() {
    // 1. Verificar si hay datos en localStorage
    const userDataString = localStorage.getItem('userData');
    console.log('1. Datos raw en localStorage:', userDataString);

    if (!userDataString) {
        console.log('No hay datos en localStorage');
        return;
    }

    // 2. Intentar parsear los datos
    try {
        const userData = JSON.parse(userDataString);
        console.log('2. Datos parseados:', userData);

        // 3. Obtener referencias a los elementos del DOM
        const nombreElement = document.querySelector('.nombre');
        const correoElement = document.querySelector('.correo-usuario');
        const contrasenaElement = document.querySelector('.contraseña-usuario');

        console.log('3. Elementos del DOM encontrados:', {
            nombre: nombreElement,
            correo: correoElement,
            contrasena: contrasenaElement
        });

        // 4. Actualizar los elementos si existen
        if (nombreElement) {
            nombreElement.textContent = userData.nombre || 'Usuario';
            console.log('4. Nombre actualizado a:', userData.nombre);
        }
        
        if (correoElement) {
            correoElement.textContent = userData.correo;
            console.log('4. Correo actualizado a:', userData.correo);
        }
        
        if (contrasenaElement) {
            contrasenaElement.textContent = userData.contrasena;
            console.log('4. Contraseña actualizada');
        }

    } catch (error) {
        console.error('Error al procesar datos:', error);
    }
}

// Asegurarnos que el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Ejecutando cargarDatosUsuario');
    cargarDatosUsuario();
});

// Función para cargar el avatar (manteniendo tu código existente)
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
    console.log('Ventana cargada');
    loadAvatarFromLocalStorage();
    cargarDatosUsuario(); // Llamamos la función nuevamente por si acaso
};

window.addEventListener('storage', function(event) {
    if (event.key === 'selectedAvatar') {
        loadAvatarFromLocalStorage();
    }
    if (event.key === 'userData') {
        cargarDatosUsuario();
    }
});

// Agregar una función para verificar manualmente los datos
window.verificarDatos = function() {
    console.log('Verificación manual de datos:');
    console.log('localStorage completo:', localStorage);
    console.log('userData específico:', localStorage.getItem('userData'));
    cargarDatosUsuario();
};