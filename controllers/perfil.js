// Constante para capturar el modal.
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
// Constante para capturar el formulario.
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener los datos del usuario que ha iniciado sesión.
    const JSON = await fetchData(USUARIO_API, 'leerPerfil');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        document.getElementById('usuario').value = JSON.dataset.usuario;
        // document.getElementById('empleado').value = JSON.dataset.empleado;
        document.getElementById('tipous').value = JSON.dataset.tipousuario;
        // document.getElementById('cargoemp').value = JSON.dataset.cargo;
        // document.getElementById('correoemp').value = JSON.dataset.correoemp;
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
    const JSON = await fetchData(USUARIO_API, 'cambiarClave', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
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
    EJECUTAR_FORMULARIO.reset();
}