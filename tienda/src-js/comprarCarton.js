document.getElementById('redirigirTienda').addEventListener('click', function(){
  window.location.href = "/tienda/tienda.html";
});

// Cargar avatar seleccionado desde localStorage
const selectedCarton = JSON.parse(localStorage.getItem('selectedCarton'));

if (selectedCarton) {
const cartonContainer = document.querySelector('.contenedorCarton');
const precioContainer = document.querySelector('.precio');

cartonContainer.innerHTML = `<img src="${selectedCarton.src}" alt="${selectedCarton.alt} class="carton-imagen"">`;
precioContainer.innerHTML = `<span class="precio-texto">Precio: ${selectedCarton.price}</span>`;

// Manejar el clic en el botón de comprar
document.getElementById('comprarBtn').addEventListener('click', () => {
  if (selectedCarton.locked) {
    // Lógica para realizar la compra
    alert('Carton comprado!');
    // Actualizar estado del avatar (desbloquearlo)
    selectedCarton.locked = false;
    localStorage.setItem('selectedCarton', JSON.stringify(selectedCarton));
    // Redirigir a la pantalla anterior o perfil
    window.location.href = '/tienda/tienda.html';
  }
});
}

else{
  console.error('no hay ningun carton seleccionado')
}