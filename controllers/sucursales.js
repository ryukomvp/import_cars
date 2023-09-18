// Constante para completar la ruta de la API.
const SUCURSAL_API = 'business/sucursales.php';
// Constante para establecer el formulario de buscar.
const BUSCAR_FORMULARIO = document.getElementById('buscarFormulario');
// Constante para establecer el formulario de guardar.
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para establecer el título de la modal.
const TITULO = document.getElementById('titulo');
// Constantes para establecer el contenido de la tabla.
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Se inicializa el componente Modal para que funcionen las cajas de diálogo.
// Constante para establecer la modal de guardar.
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
BUSCAR_FORMULARIO.addEventListener('submit', (event) => {
    document.getElementById('ejecutarFormulario').autocomplete = 'off';
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(BUSCAR_FORMULARIO);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(SUCURSAL_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
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
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(SUCURSAL_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="bg-white hover:bg-blue-200">
                    <td class="hidden px-6 py-4">
                        ${row.idsucursal}
                    </td>
                    <td class="px-6 py-4">
                        ${row.nombresuc}
                    </td>
                    <td class="px-6 py-4">
                        ${row.telefonosuc}
                    </td>
                    <td class="px-6 py-4">
                        ${row.correosuc}
                    </td>
                    <td class="px-6 py-4">
                        ${row.direccionsuc}
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="openUpdate(${row.idsucursal})"
                            class="text-blue-700 border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/1A56DB/synchronize.png" />
                        </button>
                        <button onclick="openDelete(${row.idsucursal})"
                            class="text-red-700 border border-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/C81E1E/delete--v1.png" />
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
function openCreate() {
    // Se abre la caja de diálogo que contiene el formulario.
    ABRIR_MODAL.show();
    // Se restauran los elementos del formulario.
    EJECUTAR_FORMULARIO.reset();
    // Texto del boton para crear un registro
    BTN_ACCION.textContent = 'Añadir';
    // Se asigna título a la caja de diálogo.
    TITULO.textContent = 'Crear sucursal';
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idsucursal', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(SUCURSAL_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        // Se restauran los elementos del formulario.
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para crear un registro
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar sucursal';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idsucursal;
        document.getElementById('nombre').value = JSON.dataset.nombresuc;
        document.getElementById('telefono').value = JSON.dataset.telefonosuc;
        document.getElementById('correo').value = JSON.dataset.correosuc;
        document.getElementById('direccion').value = JSON.dataset.direccionsuc;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la sucursal de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idsucursal', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(SUCURSAL_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}