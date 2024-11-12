document.getElementById('submitBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón

    const primer_nombre = document.getElementById('primer_nombre').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (primer_nombre === '' || email === '' || password === '') {
        const email = document.getElementById('email');
        
        return;
    }

    const data = {
        primer_nombre: primer_nombre,
        email: email,
        password: password
    };

    // Verificar qué datos se están enviando
    console.log("Datos que se están enviando:", data);

    fetch('php/registro.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.success) {
            alert(data.message);
            // Redirigir al usuario después de un registro exitoso
            window.location.href = "/Bingo-sauro/login/inicioSesion/InicioSesion.html";
        } else {
            alert(data.errors ? data.errors.join('\n') : 'Error en el registro');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error al procesar el registro');
    });
});