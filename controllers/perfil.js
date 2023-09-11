

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener los datos del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USUARIO_API, 'leerUnRegistro');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        //Cargar estado que se encuentra en la base de datos si esta activa o no la verificación en dos pasos
        if (JSON.dataset.verificacion) {
            document.getElementById('verificacion').checked = true;
        } else {
            document.getElementById('verificacion').checked = false;
        }
    } else {
        sweetAlert(2, JSON.exception, null);
    }
});