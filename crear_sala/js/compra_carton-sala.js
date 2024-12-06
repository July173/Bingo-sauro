document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM cargado correctamente.");

    try {
        const selectedCarton = JSON.parse(localStorage.getItem('selectedCarton'));

        if (!selectedCarton) {
            console.error('No se encontró ningún cartón seleccionado en localStorage.');
            return;
        }

        const cartonContainer = document.querySelector('.contenedorCartonSeleccionado');
        const precioContainer = document.querySelector('.precio');

        if (!cartonContainer || !precioContainer) {
            console.error('No se encontraron los contenedores en el DOM.');
            return;
        }

        // Crear un elemento img para mostrar el cartón
        const cartonImg = document.createElement('img');
        cartonImg.src = selectedCarton.src;
        cartonImg.alt = "Cartón a comprar";
        cartonImg.style.marginTop = "5vw";
        cartonImg.style.width = '18vw'; // Ajusta según sea necesario
        cartonImg.style.height = '18vw'; // Ajusta según sea necesario
        cartonImg.style.borderRadius = '2rem'; // Redondear bordes
        cartonContainer.appendChild(cartonImg);
        
        function adjustAvatarSize() {
            const isPortrait = window.matchMedia('(orientation: portrait)').matches;
          
            if (isPortrait) {
              cartonImg.style.width = '60vw'; // Ajustes para modo portrait
              cartonImg.style.height = '60vw';
              cartonImg.style.marginTop = '30vw';
              
            } else {
                cartonImg.style.width = '20vw'; // Ajustes para modo landscape
                cartonImg.style.height = '20vw';
              
            }
          }
          // Escucha cambios en la orientación
          const mediaQueryList = window.matchMedia('(orientation: portrait)');
          mediaQueryList.addEventListener('change', adjustAvatarSize);
          
          // Llama a la función inicialmente para configurar los estilos
          adjustAvatarSize();

        // Mostrar el precio del cartón
        precioContainer.textContent = ` ${selectedCarton.price}`; 
        const priceIcon = document.createElement('img');
        priceIcon.src = '../Generales/img/moneditas.png'; 
        priceIcon.style.width = '4vw'; // Ajusta el tamaño según sea necesario
        priceIcon.style.height = '4vw'; // Ajusta el tamaño según sea necesario
        priceIcon.style.marginLeft = '5px'; // Espaciado opcional

        // Agregar la imagen al contenedor de precio
        precioContainer.appendChild(priceIcon);
    } catch (error) {
        console.error('Error al cargar el cartón seleccionado:', error);
    }
});

  document.addEventListener("DOMContentLoaded", function () {
    const comprarBtn = document.getElementById('comprarBtn');
    const selectedCarton = JSON.parse(localStorage.getItem('selectedCarton'));

    if (!selectedCarton) {
        console.error('No se encontró el artículo seleccionado en localStorage.');
        alert('No se encontró el artículo seleccionado.');
        comprarBtn.disabled = true; // Deshabilitar botón si no hay artículo seleccionado
        return;
    }

    const idArticulo = selectedCarton.id;

    // Verificar si el artículo ya fue comprado
    const articulosComprados = JSON.parse(localStorage.getItem('articulosComprados')) || {};
    if (articulosComprados[idArticulo]) {
        comprarBtn.textContent = 'Comprado';
        comprarBtn.disabled = true;
        comprarBtn.style.backgroundColor = '#ccc'; // Opcional
        return;
    }

    // Evento cuando el usuario hace clic en el botón de compra
    comprarBtn.addEventListener('click', function () {
        const precioArticulo = selectedCarton.price;

        console.log('ID del artículo seleccionado:', idArticulo);
        console.log('Precio del artículo seleccionado:', precioArticulo);

        // Llamar a la función de compra
        comprarArticulo(idArticulo, precioArticulo);
    });
});

// Función para realizar la compra
function comprarArticulo(idArticulo, precioArticulo) {
    console.log('Iniciando compra...');

    fetch('./../perfil/php/compra.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idArticulo: idArticulo,
            precioArticulo: precioArticulo
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                console.log('Compra exitosa. Monedas restantes:', data.monedas_restantes);
                alert('Compra realizada con éxito. ¡Disfruta de tu artículo!');

                // Marcar el artículo como comprado
                const articulosComprados = JSON.parse(localStorage.getItem('articulosComprados')) || {};
                articulosComprados[idArticulo] = true;
                localStorage.setItem('articulosComprados', JSON.stringify(articulosComprados));

                // Actualizar el botón
                const comprarBtn = document.getElementById('comprarBtn');
                comprarBtn.textContent = 'Comprado';
                comprarBtn.disabled = true;
                comprarBtn.style.backgroundColor = '#ccc'; // Opcional
            } else {
                console.error('Error en la compra:', data.mensaje);
                alert(data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la compra:', error);
            alert('Hubo un error al procesar la compra.');
        });
}
