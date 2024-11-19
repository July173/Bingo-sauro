document.getElementById('logoutButton').addEventListener('click', function () {
    fetch('../../Generales/configuracion/php/cerrar-sesion.php', {
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
                window.location.href = "http://localhost/Bingo-sauro/login/Bienvenido/pag2.html";
            }
        })
        .catch((error) => {
            console.error('Error al cerrar sesión:', error);
        });
});
