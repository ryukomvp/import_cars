// Constante para completar la ruta de la API.
const PRODUCTOS_API = 'business/producto.php';
const CODIGOS_COMUNES_API = 'business/comidogosComun.php';
const PROVEEDORES_API = 'business/proveedores.php';
const CATEGORIAS_API = 'business/categorias.php';
const MODELOS_API = 'business/modelos.php';
const PAISES_API = 'business/paisOrigen.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Se inicializa el componente Modal para que funcionen las cajas de diálogo.
M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);
// Constante para establecer la modal de guardar.
const SAVE_MODAL = M.Modal.getInstance(document.getElementById('save-modal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(CATEGORIES_API, action, FORM);
    console.log(JSON);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        SAVE_MODAL.close();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    }
    else {
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
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'leerTodo';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CATEGORIES_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td><img src="${SERVER_URL}images/productos/${row.foto}" class="materialboxed" height="100"></td>
                    <td>${row.imagen}</td>
                    <td>${row.nombre}</td>
                    <td>${row.nomenclatura}${row.codigo}</td>
                    <td>${row.descripcion}</td>
                    <td>${row.precio}</td>
                    <td>${row.proveedor}</td>
                    <td>${row.categoria}</td>
                    <td>${row.modelo}</td>
                    <td>
                        <button onclick="openUpdate(${row.idproducto})" class="btn blue tooltipped" data-tooltip="Actualizar">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    <td>
                        <button onclick="openDelete(${row.idproducto})" class="btn red tooltipped" data-tooltip="Eliminar">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS.textContent = JSON.message;
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
    SAVE_MODAL.open();
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear Producto';
    // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
    fillSelect(CODIGOS_COMUNES_API, 'LeerCodigos', 'codigo_comun');
    fillSelect(PROVEEDORES_API, 'LeerProveedores', 'Proveedor');
    fillSelect(CATEGORIAS_API, 'LeerCategorias', 'categoria');
    fillSelect(MODELOS_API, 'LeerModelos', 'modelo');
    fillSelect(PAISES_API, 'LeerPaises', 'pais');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CATEGORIES_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.open();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar categoría';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_categoria;
        document.getElementById('nombre').value = JSON.dataset.categoria;
        document.getElementById('descripcion').value = JSON.dataset.descripcion;
        // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
        M.updateTextFields();
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
    const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_categoria', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CATEGORIES_API, 'delete', FORM);
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

/*
*   Función para abrir el reporte de productos de una categoría.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
// function openReport(id) {
//     // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
//     const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_categoria.php`);
//     // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
//     PATH.searchParams.append('id_categoria', id);
//     // Se abre el reporte en una nueva pestaña del navegador web.
//     window.open(PATH.href);
// }