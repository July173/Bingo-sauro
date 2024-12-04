window.onload = function() {
    // Guardar la página anterior si no viene de un refresh
    if (document.referrer && !sessionStorage.getItem('previousPage')) {
        sessionStorage.setItem('previousPage', document.referrer);
        console.log('Página anterior guardada:', document.referrer); // Para depuración
    } else {
        console.log('No se guardó la página anterior. Referrer:', document.referrer); // Para depuración
    }
};

document.querySelector('.close-btn').addEventListener('click', function() {
    const previousPage = sessionStorage.getItem('previousPage');
    console.log('Página anterior:', previousPage); // Para depuración
    if (previousPage) {
        window.location.href = previousPage; // Redirige a la página anterior
    } else {
        window.location.href = '../home/inicio.php'; // Asegúrate de que esta ruta sea correcta
    }
});

document.getElementById('logoutButton').addEventListener('click', function () {
    clearMusicStorage(); // Limpiar el estado de la música
    fetch('php/cerrar-sesion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.logout) {
                // Eliminar cualquier dato almacenado localmente
                sessionStorage.clear();
                localStorage.clear();
                alert(data.mensaje);

                // Redirigir al usuario al inicio de sesión
                window.location.href = "./../../login/bienvenido/pag2.html";
            }
        })
        .catch((error) => {
            console.error('Error al cerrar sesión:', error);
        });
});

sessionStorage.clear(); // Limpia el sessionStorage para pruebas