// Constante para completar la ruta de la API.
const USUARIOS_API = 'business/usuarios.php';
// Constante para capturar el modal.
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para establecer el título de la modal.

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

// Método manejador de eventos para cuando se envía el formulario de cambiar contraseña.
EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(USUARIOS_API, 'cambiarClave', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.exception, false);
    }
});

/*
*   Función para preparar el formulario al momento de cambiar la constraseña.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function abrirModalClave() {
    // Se abre la caja de diálogo que contiene el formulario.
    ABRIR_MODAL.show();
    // Se restauran los elementos del formulario.
    ABRIR_MODAL.reset();
}