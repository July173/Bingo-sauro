let isVibrationActive = false; // Variable para controlar el estado de la vibración
const vibrateButton = document.getElementById('vibrateButton');

vibrateButton.addEventListener('click', function() {
  if (navigator.vibrate) {
    if (!isVibrationActive) {
      // Activar la vibración con un patrón
      navigator.vibrate([300, 100, 200]); 
      vibrateButton.textContent = 'Desactivar vibración';
      isVibrationActive = true;
    } else {
      // Desactivar la vibración
      navigator.vibrate(0); // 0 detiene cualquier vibración activa
      vibrateButton.textContent = 'Activar vibración';
      isVibrationActive = false;
    }
  } else {
    alert('Este dispositivo no soporta vibración');
  }
});