// Constante para completar la ruta de la API.
const CLIENTES_API = 'business/clientes.php';
// Constante para completar la ruta de la API.
const PLAZOS_API = 'business/plazos.php';
// Constante para establecer el formulario de buscar.
const FORMULARIO_BUSQUEDA = document.getElementById('buscarFormulario');
// Constante para establecer el formulario de guardar.
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para establecer el título de la modal.
const TITULO = document.getElementById('titulo');
// Constantes para establecer el contenido de la tabla.
const REGISTROS_TABLA = document.getElementById('registros');
// Constante para capturar el modal.
const ACCIONES_MODAL = new Modal(document.getElementById('abrirModal'));
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // se quita el autollenado de los campos del formulario
    document.getElementById('ejecutarFormulario').autocomplete = 'off';
    // Llamada a la función para llenar la tabla con los registros disponibles.
    cargarRegistros();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
FORMULARIO_BUSQUEDA.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_BUSQUEDA);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    cargarRegistros(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'actualizarRegistro' : action = 'crearRegistro';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(CLIENTES_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        cargarRegistros();
        // Se cierra la caja de diálogo.
        ACCIONES_MODAL.hide();
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
async function cargarRegistros(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CLIENTES_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="bg-white hover:bg-blue-200">
                    <td class="hidden">
                        ${row.idcliente}
                    </td>
                    <td>
                        ${row.nombre}
                    </td>
                    <td>
                        ${row.giro}
                    </td>
                    <td>
                        ${row.dui}
                    </td>
                    <td>
                        ${row.correo}
                    </td>
                    <td>
                        ${row.telefono}
                    </td>
                    <td>
                        ${row.contacto}
                    </td>
                    <td>
                        ${row.descuento}
                    </td>
                    <td>
                        ${row.exoneracion}
                    </td>
                    <td>
                        ${row.fechaini}
                    </td>
                    <td>
                        ${row.tipocliente}
                    </td>
                    <td>
                        ${row.descripcion}
                    </td>
                    <td>
                        <button onclick="actualizarRegistro(${row.idcliente})"
                        class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 mb-2"
                        type="button">
                            <svg class="w-[30px] h-[30px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                            </svg>
                        </button>
                        <button onclick="eliminarRegistro(${row.idcliente})"  
                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                            type="button">
                            <svg class="w-[30px] h-[30px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                            </svg>
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
    ACCIONES_MODAL.show();
    // Se restauran los elementos del formulario.
    EJECUTAR_FORMULARIO.reset();
    // Texto del boton para crear un registro
    BTN_ACCION.textContent = 'Añadir';
    // Se asigna título a la caja de diálogo.
    TITULO.textContent = 'Crear un registro';
    fillSelect(CLIENTES_API, 'leerTiposClientes', 'tipoCliente');
    fillSelect(PLAZOS_API, 'leerRegistros', 'plazo');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CLIENTES_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ACCIONES_MODAL.show();
        // Se restauran los elementos del formulario.
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para crear un registro
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar un registro';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idbodega;
        document.getElementById('nombre').value = JSON.dataset.nombre;
        document.getElementById('giro').value = JSON.dataset.giro;
        document.getElementById('dui').value = JSON.dataset.dui;
        document.getElementById('correo').value = JSON.dataset.correo;
        document.getElementById('telefono').value = JSON.dataset.telefono;
        document.getElementById('contacto').value = JSON.dataset.contacto;
        document.getElementById('descuento').value = JSON.dataset.descuento;
        document.getElementById('exoneracion').value = JSON.dataset.exoneracion;
        document.getElementById('fechaIni').value = JSON.dataset.fechaini;
        fillSelect(CLIENTES_API, 'leerTiposClientes', 'tipoCliente', JSON.dataset.tipocliente);
        fillSelect(PLAZOS_API, 'leerRegistros', 'plazo', JSON.dataset.idplazo);
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
    const RESPONSE = await confirmAction('¿Desea eliminar el cliente de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idcliente', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CLIENTES_API, 'eliminarRegistro', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            cargarRegistros();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}