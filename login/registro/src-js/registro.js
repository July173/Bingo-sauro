document.getElementById('submitBtn').addEventListener('click', function () {
    const username = document.getElementById('primer_nombre').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (username === '' || email === '' || password === '') {
        alert('Por favor, completa todos los campos antes de enviar.');
        return;
    }

    const data = {
        username: username,
        email: email,
        password: password
    };

    // Verificar qué datos se están enviando
    console.log("Datos que se están enviando:", data);

    fetch('php/registro.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Asegúrate de que el Content-Type sea JSON
        },
        body: JSON.stringify(data) // Convierte el objeto 'data' a JSON
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.message) {
            alert(data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
