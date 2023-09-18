// Constante para completar la ruta de la API.
const PRODUCTOS_API = 'business/productos.php';
const CODIGOS_COMUNES_API = 'business/codigosComunes.php';
const CATEGORIAS_API = 'business/categorias.php';
const MODELOS_API = 'business/modelos.php';
const PAISES_API = 'business/paisesOrigen.php';
const TIPO_API = 'business/tiposProductos.php';
// Constante para establecer el formulario de buscar.
const BUSCAR_FORMULARIO = document.getElementById('buscarFormulario');
// Constante para establecer el formulario de guardar.
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para establecer el título de la modal.
const TITULO = document.getElementById('titulo');
// Constantes para establecer el contenido de la tabla.
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Constante para abrir o cerrar el modal
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // se quita el autollenado de los campos del formulario
    document.getElementById('ejecutarFormulario').autocomplete = 'off';
    // Llamada a la función para llenar la tabla con los registros disponibles.
    rellenarTabla();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
BUSCAR_FORMULARIO.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(BUSCAR_FORMULARIO);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    rellenarTabla(FORM);
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
    const JSON = await dataFetch(PRODUCTOS_API, action, FORM);
    console.log(JSON);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        rellenarTabla();
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
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
async function rellenarTabla(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden px-6 py-4">${row.idproducto}</td>
                    <td class="flex justify-center px-6 py-4"><img src="${SERVER_URL}images/productos/${row.imagen}" class="h-28 w-28"></td>
                    <td class="px-6 py-4">${row.nombreprod}</td>
                    <td class="px-6 py-4">${row.codigo}</td>
                    <td class="px-6 py-4">${row.anioinicial}-${row.aniofinal}</td>
                    <td class="px-6 py-4">${row.precio}</td>
                    <td class="px-6 py-4">${row.preciodesc}</td>
                    <td class="px-6 py-4">${row.categoria}</td>
                    <td class="px-6 py-4">${row.modelo}</td>
                    <td class="px-6 py-4">${row.pais}</td>
                    <td class="px-6 py-4">${row.estadoproducto}</td>
                    <td class="px-6 py-4" >
                        <button onclick="actualizarRegistro(${row.idproducto})"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>

                        <button onclick="eliminarRegistro(${row.idproducto})"
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
    ABRIR_MODAL.show();
    // Se restauran los elementos del formulario.
    EJECUTAR_FORMULARIO.reset();
    // Texto del boton para crear un registro
    BTN_ACCION.textContent = 'Añadir';
    // Se asigna título a la caja de diálogo.
    TITULO.textContent = 'Crear Producto nuevo';
    // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
    fillSelect(CODIGOS_COMUNES_API, 'leerRegistros', 'codigo');
    fillSelect(CATEGORIAS_API, 'leerRegistros', 'categoria');
    fillSelect(MODELOS_API, 'leerRegistros', 'modelo');
    fillSelect(PAISES_API, 'leerRegistros', 'paisorigen');
    fillSelect(PRODUCTOS_API, 'leerEstado', 'estado');
    fillSelect(TIPO_API, 'leerRegistros', 'tipo');
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
    const JSON = await dataFetch(PRODUCTOS_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        // Se restauran los elementos del formulario.
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para actualizar un registro 
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar producto';
        // Se inicializan los campos del formulario.
        // Se establece el campo de archivo como opcional.
        document.getElementById('archivo').required = false;
        document.getElementById('id').value = JSON.dataset.idproducto;
        document.getElementById('nombreprod').value = JSON.dataset.nombreprod;
        document.getElementById('descripcion').value = JSON.dataset.descripcionprod;
        document.getElementById('precio').value = JSON.dataset.precio;
        document.getElementById('preciodesc').value = JSON.dataset.preciodesc;
        document.getElementById('anioinicial').value = JSON.dataset.anioinicial;
        document.getElementById('aniofinal').value = JSON.dataset.aniofinal;
        fillSelect(CODIGOS_COMUNES_API, 'leerRegistros', 'codigo',JSON.dataset.idcodigocomun);
        fillSelect(CATEGORIAS_API, 'leerRegistros', 'categoria',JSON.dataset.idcategoria);
        fillSelect(MODELOS_API, 'leerRegistros', 'modelo',JSON.dataset.idmodelo);
        fillSelect(PAISES_API, 'leerRegistros', 'paisorigen',JSON.dataset.idpais);
        fillSelect(PRODUCTOS_API, 'leerEstado', 'estado',JSON.dataset.estadoproducto);
        fillSelect(TIPO_API, 'leerRegistros', 'tipo',JSON.dataset.idtipoproducto);
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
    const MENSAJE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (MENSAJE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idproducto', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTOS_API, 'eliminarRegistro', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            rellenarTabla();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

