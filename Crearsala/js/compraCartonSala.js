window.onload = function () {
    const selectedCarton = JSON.parse(localStorage.getItem('selectedCarton'));
  
    if (selectedCarton) {
        const cartonContainer = document.querySelector('.contenedorCartonSeleccionado');
        const precioContainer = document.querySelector('.precio');
  
        // Verifica si los contenedores se están seleccionando correctamente
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
  
        // Mostrar el precio del cartón
        precioContainer.textContent = ` ${selectedCarton.price}`; 
        const priceIcon = document.createElement('img');
        priceIcon.src = '../Generales/img/moneditas.png'; 
        priceIcon.style.width = '4vw'; // Ajusta el tamaño según sea necesario
        priceIcon.style.height = '4vw'; // Ajusta el tamaño según sea necesario
        priceIcon.style.marginLeft = '5px'; // Espaciado opcional
  
        // Agregar la imagen al contenedor de precio
        precioContainer.appendChild(priceIcon);
    } else {
        console.error('No se encontró ningún cartón seleccionado en localStorage.');
    }
  };