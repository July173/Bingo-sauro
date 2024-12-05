function girarBombo() {
    const balotera = document.getElementById('baloteraImg');
    const imagenOriginal = './../generales/img/boleteraQuieta.png';
    const imagenGirando = './../generales/img/boleteraMoviendose.png';
  
    // Cambiar a la imagen de giro
    balotera.src = imagenGirando;
  
    // Volver a la imagen original después de 500ms (puedes ajustar el tiempo)
    setTimeout(() => {
      balotera.src = imagenOriginal;
    }, 700);
  }
  