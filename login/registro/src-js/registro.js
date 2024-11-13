document.getElementById('submitBtn').addEventListener('click', async function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón

    const primer_nombre = document.getElementById('primer_nombre');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    // Verificación de campos vacíos
    let hasEmptyField = false;

    if (primer_nombre.value === '') {
        primer_nombre.classList.add('is-invalid');
        hasEmptyField = true;
    } else {
        primer_nombre.classList.remove('is-invalid');
    }

    if (email.value === '') {
        email.classList.add('is-invalid');
        hasEmptyField = true;
    } else {
        email.classList.remove('is-invalid');
    }

    if (password.value === '') {
        password.classList.add('is-invalid');
        hasEmptyField = true;
    } else {
        password.classList.remove('is-invalid');
    }

    // Si hay algún campo vacío, mostrar una alerta y salir de la función
    if (hasEmptyField) {
        alert('Por favor, complete todos los campos.');
        return;
    }

    // Verificar si el correo ya existe
    const emailExists = await checkIfEmailExists(email.value);
    if (emailExists) {
        alert('El correo ya está registrado. Por favor, use otro correo.');
        email.classList.add('is-invalid');
        return;
    }

    // Crear el objeto de datos a enviar si todos los campos están completos y el correo no existe
    const data = {
        primer_nombre: primer_nombre.value,
        email: email.value,
        password: password.value
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

// Función para verificar si el correo ya existe en la base de datos
async function checkIfEmailExists(email) {
    try {
        const response = await fetch(`php/verificarEmail.php?email=${encodeURIComponent(email)}`);
        if (!response.ok) {
            throw new Error('Error al verificar el correo en el servidor');
        }
        const data = await response.json();
        return data.exists; // Debería devolver true si el correo ya existe
    } catch (error) {
        console.error('Error:', error);
        alert('Error al verificar el correo');
        return false;
    }
}
