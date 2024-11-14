document.getElementById('submitBtn').addEventListener('click', async function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón

    const primer_nombre = document.getElementById('primer_nombre');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    // Lista de palabras ofensivas
    const offensiveWords = ['maldicion', 'palabraofensiva', 'putas', 'locas', 'perras'];
    let hasEmptyField = false;

    // Validación del nombre de usuario: mínimo 5 caracteres y sin palabras ofensivas
    if (primer_nombre.value.length < 5 || offensiveWords.some(word => primer_nombre.value.toLowerCase().includes(word))) {
        primer_nombre.classList.add('is-invalid');
        hasEmptyField = true;
    } else {
        primer_nombre.classList.remove('is-invalid');
    }

    // Verificación de campos vacíos para email y password
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

    // Si hay campos vacíos o el nombre de usuario es inválido, no continuar
    if (hasEmptyField) return;

    // Crear el objeto de datos a enviar si todos los campos están completos y válidos
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
