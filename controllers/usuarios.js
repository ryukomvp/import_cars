// Constante para completar la ruta de la API.
const USUARIO_API = 'business/usuarios.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
// Constantes para establecer el contenido de la tabla.
const BTN_TEXTO = document.getElementById('accion');

// Constante para capturar el modal.
const SAVE_MODAL = new Modal(document.getElementById('modal_add_user'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    registrosTabla();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    registrosTabla(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'actualizar' : action = 'crear';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        registrosTabla();
        // Se cierra la caja de diálogo.
        SAVE_MODAL.toggle();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function registrosTabla(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscar' : action = 'leerUsuarios';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr class="text-center bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-200 dark:hover:bg-gray-600">
                    <td>${row.idusuario}</td>
                    <td>${row.usuario}</td>
                    <td>${row.pin}</td>
                    <td>${row.tipousuario}</td>
                    <td>${row.empleado}</td>
                    <td>${row.estadousuario}</td>
                    <td>
                        <button onclick="actualizarRegistro(${row.idusuario})"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>
                        <button onclick="eliminarRegistro(${row.idusuario})"  
                            class="md:w-auto text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/FFFFFF/delete--v1.png" />
                        </button>
                    </td>
                </tr>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function crearRegistro() {
    // Se abre la caja de diálogo que contiene el formulario.
    SAVE_MODAL.show();
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Añadir nuevo usuario';
    // Se asigna texto al botón de acción.
    BTN_TEXTO.textContent = 'Añadir';
    // Se habilitan los campos necesarios
    // Se deshabilitan los campos necesarios.
    document.getElementById('nombre').disabled = false;
    document.getElementById('pin').disabled = false;
    document.getElementById('clave').disabled = false;
    document.getElementById('confirmar').disabled = false;
    // Se cargan los datos del/los componente/s select 
    fillSelect(USUARIO_API, 'leerTipos', 'tipo');
    fillSelect(USUARIO_API, 'leerEmpleados', 'empleado');
    fillSelect(USUARIO_API, 'leerEstados', 'estado');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idusuario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'leerUsuario', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna título a la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar usuario';
        // Se asigna texto al botón de acción.
        BTN_TEXTO.textContent = 'Actualizar';
        // Se deshabilitan los campos necesarios.
        // document.getElementById('nombre').disabled = true;
        // document.getElementById('pin').disabled = true;
        document.getElementById('clave').disabled = true;
        document.getElementById('confirmar').disabled = true;
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idusuario;
        document.getElementById('nombre').value = JSON.dataset.usuario;
        document.getElementById('pin').value = JSON.dataset.pin;
        document.getElementById('clave').value = JSON.dataset.contrasenia;
        document.getElementById('confirmar').value = JSON.dataset.contrasenia;
        fillSelect(USUARIO_API, 'leerTipos', 'tipo', JSON.dataset.tipousuario);
        fillSelect(USUARIO_API, 'leerEmpleados', 'empleado', JSON.dataset.idempleado);
        fillSelect(USUARIO_API, 'leerEstados', 'estado', JSON.dataset.estadousuario);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function eliminarRegistro(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idusuario', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'eliminar', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            registrosTabla();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}