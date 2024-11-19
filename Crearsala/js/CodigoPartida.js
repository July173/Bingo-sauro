// Función asíncrona para generar el código de la partida
async function generarCodigoPartida() {
  try {
      const response = await fetch("../../../Bingo-sauro/Crearsala/php/crear_codigo.php");
      
      if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data.success) {
          // Guardar el código en localStorage
          localStorage.setItem("codigoPartida", data.codigo_sala);

          console.log("El código se ha guardado correctamente:", data.codigo_sala);
          return true; // Indica que se generó correctamente
      } else {
          console.error("Error desde el servidor:", data.error);
          return false; // Indica que no se generó
      }
  } catch (error) {
      console.error("Error al generar el código:", error);
      return false;
  }
}





