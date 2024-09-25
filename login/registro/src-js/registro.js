const cuadroAceptar = document.getElementById('miCuadro');
cuadroAceptar.addEventListener('click', () => {
    cuadroAceptar.classList.toggle('cambiado');
});

document.getElementById('redirigirIniciar').addEventListener('click', function(){
    window.location.href = "/login/inicioSesion/InicioSesion.html"
});
document.getElementById('redirigir').addEventListener('click', function(){
    window.location.href = "/login/inicioSesion/InicioSesion.html"
});