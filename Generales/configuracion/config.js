window.onload = function() {
    // Guardar la página anterior si no viene de un refresh
    if (document.referrer && !sessionStorage.getItem('previousPage')) {
        sessionStorage.setItem('previousPage', document.referrer);
    }
};

document.querySelector('.close-btn').addEventListener('click', function() {
    const previousPage = sessionStorage.getItem('previousPage');
    if (previousPage) {
        window.location.href = previousPage;
    } else {
        history.back();
    }
});

document.getElementById('logoutButton').addEventListener('click', function () {
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

// Agregar este código para manejar el botón de retorno
document.addEventListener('DOMContentLoaded', function() {
    const botonRegresar = document.getElementById('botonRegresar');
    
    if (botonRegresar) {
        botonRegresar.onclick = function() {
            alert('¡Botón clickeado!');
            window.history.back();
        };
    } else {
        console.error('No se encontró el botón');
    }
});
