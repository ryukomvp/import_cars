
// Constante para la ruta del business que conecta a los metodos del SCRUD
const DETALLE_TRANSACCION_API = 'business/detallesTransacciones.php';
// Constante para la ruta del business que conecta a los metodos del SCRUD
const BODEGA_API = 'business/bodegas.php';
// Constante para la ruta del business que conecta a los metodos del SCRUD
const PRODUCTOS_API = 'business/productos.php';
// Constante para la ruta del business que conecta a los metodos del SCRUD
const ENCABEZADO_TRANSACCION_API = 'business/encabezadosTransacciones.php';
// Constante para el input de busqueda
const FORMULARIO_BUSQUEDA = document.getElementById('buscarFormulario');
// Constante para el formulario del modal, sirve para añadir y editar
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para rellenar la tabla de los datos registrados en la base
const REGISTROS_TABLA = document.getElementById('registros');
// Constante para nombrar el modal dependiendo de la acción que se haga
const TITULO = document.getElementById('titulo');
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Constante para abrir o cerrar el modal
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));


// Metodo para cargar la pagina cada vez que haya un cambio en el DOM
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('ejecutarFormulario').autocomplete = 'off';
    // Llamada a la función para llenar la tabla con los registros disponibles.
    cargarRegistros();
});

// Metodo para el input de busqueda
FORMULARIO_BUSQUEDA.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_BUSQUEDA);
    // LLama la función de rellenar la tabla para actualizarla con los datos de la busqueda.
    cargarRegistros(FORM);
});

// Metodo para el modal, añade o actualiza dependiendo de la acción
EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica si se realizara una actualización o un registro nuevo.
    (document.getElementById('id').value) ? action = 'actualizarRegistro' : action = 'crearRegistro';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(DETALLE_TRANSACCION_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        cargarRegistros();
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});
// Metodo para cargar la tabla con los datos de la base
async function cargarRegistros(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(DETALLE_TRANSACCION_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr  class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden px-6 py-4">${row.iddetalletransaccion}</td>
                    <td class="px-6 py-4">${row.correlativo}</td>
                    <td class="px-6 py-4">${row.cantidad}</td>
                    <td class="px-6 py-4">${row.preciounitario}</td>
                    <td class="px-6 py-4">${row.ventanosujeta}</td>
                    <td class="px-6 py-4">${row.ventaexenta}</td>
                    <td class="px-6 py-4">${row.ventaafecta}</td>
                    <td class="px-6 py-4">${row.descuento}</td>
                    <td class="px-6 py-4">${row.valordescuento}</td>
                    <td class="px-6 py-4">${row.sumas}</td>
                    <td class="px-6 py-4">${row.subtotal}</td>
                    <td class="px-6 py-4">${row.ventatotal}</td>
                    <td class="px-6 py-4">${row.iva}</td>
                    <td class="px-6 py-4">${row.observaciones}</td>
                    <td class="px-6 py-4">${row.bodegaEntrada}</td>
                    <td class="px-6 py-4">${row.bodegaSalida}</td>
                    <td class="px-6 py-4">${row.nombreprod}</td>
                    <td class="px-6 py-4">${row.descripcion}</td>
                    <td class="px-6 py-4">${row.nocomprobante}</td>
                    <td class="px-6 py-4">
                        <button onclick="actualizarRegistro(${row.iddetalletransaccion})"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>

                        <button onclick="eliminarRegistro(${row.iddetalletransaccion})"
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

// Funcion para abrir el modal y añadir un registro
function crearRegistro() {
    // Se abre la caja de diálogo que contiene el formulario.
    ABRIR_MODAL.show();
    EJECUTAR_FORMULARIO.reset();
    // Texto del boton para crear un registro
    BTN_ACCION.textContent = 'Añadir';
    // Se asigna el título a la caja de diálogo.
    TITULO.textContent = 'Crear un registro';
    fillSelect(BODEGA_API, 'leerRegistros', 'bodegaEntrada');
    fillSelect(BODEGA_API, 'leerRegistros', 'bodegaSalida');
    fillSelect(PRODUCTOS_API, 'leerTodo', 'producto');
    fillSelect(ENCABEZADO_TRANSACCION_API, 'leerRegistros', 'encaTransaccion');
}

//Funcion para abrir el modal con los datos del registro a actualizar
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(DETALLE_TRANSACCION_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para actualizar un registro 
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar un registro';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.iddetalletransaccion;
        document.getElementById('correlativo').value = JSON.dataset.correlativo;
        document.getElementById('cantidad').value = JSON.dataset.cantidad;
        document.getElementById('precioUnitario').value = JSON.dataset.preciounitario;
        document.getElementById('ventaNoSujeta').value = JSON.dataset.ventanosujeta;
        document.getElementById('ventaExenta').value = JSON.dataset.ventaexenta;
        document.getElementById('ventaAfecta').value = JSON.dataset.ventaafecta;
        document.getElementById('descuento').value = JSON.dataset.descuento;
        document.getElementById('valorDescuento').value = JSON.dataset.valordescuento;
        document.getElementById('suma').value = JSON.dataset.sumas;
        document.getElementById('subTotal').value = JSON.dataset.subtotal;
        document.getElementById('ventaTotal').value = JSON.dataset.ventatotal;
        document.getElementById('iva').value = JSON.dataset.iva;
        document.getElementById('observaciones').value = JSON.dataset.observaciones;
        fillSelect(BODEGA_API, 'leerRegistros', 'bodegaEntrada', JSON.dataset.idbodegaentrada);
        fillSelect(BODEGA_API, 'leerRegistros', 'bodegaSalida', JSON.dataset.idbodegasalida);
        fillSelect(PRODUCTOS_API, 'leerTodo', 'producto', JSON.dataset.idproducto);
        document.getElementById('descripcion').value = JSON.dataset.descripcion;
        fillSelect(ENCABEZADO_TRANSACCION_API, 'leerRegistros', 'encaTransaccion', JSON.dataset.idencatransaccion);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Funcion para abrir el modal con los datos del registro a eliminar
async function eliminarRegistro(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const MENSAJE = await confirmAction('¿Desea eliminar el detalle de la transaccion?');
    // Se verifica la respuesta del mensaje.
    if (MENSAJE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('iddetalletransaccion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(DETALLE_TRANSACCION_API, 'eliminarRegistro', FORM);
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