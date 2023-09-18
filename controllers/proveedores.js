// Constante para la ruta del business que conecta a los metodos del SCRUD
const PROVEEDOR_API = 'business/proveedores.php';
const MONEDA_API = 'business/monedas.php';
// Constante para el input de busqueda
const BUSCAR_FORMULARIO = document.getElementById('buscarFormulario');
// Constante para el formulario del modal, sirve para añadir y editar
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para el formulario del modal, para la grafica
const EJECUTAR_FORMULARIO2 = document.getElementById('ejecutarFormulario2');
// Constante para rellenar la tabla de los datos registrados en la base
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Constante para nombrar el modal dependiendo de la acción que se haga
const TITULO = document.getElementById('titulo');
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Constante para abrir o cerrar el modal
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
// Constante para abrir o cerrar el modal para la grafica
const ABRIR_MODAL_GRAFICA = new Modal(document.getElementById('abrirModalGrafica'));

// Metodo para cargar la pagina cada vez que haya un cambio en el DOM
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('ejecutarFormulario').autocomplete = 'off';
    // Llamada a la función para llenar la tabla con los registros disponibles.
    rellenarTabla();
});

// Metodo para el input de busqueda
BUSCAR_FORMULARIO.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(BUSCAR_FORMULARIO);
    // LLama la función de rellenar la tabla para actualizarla con los datos de la busqueda.
    rellenarTabla(FORM);
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
    const JSON = await dataFetch(PROVEEDOR_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        rellenarTabla();
        // Se cierra la caja de diálogo.
        ABRIR_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

async function abrirGrafica(idproveedor) {
    const FORM = new FormData();
    FORM.append('idproveedor', idproveedor)
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PROVEEDOR_API, 'graficaCantidadTransaccionesProveedor', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let producto = [];
        let cantidad_transacciones = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            producto.push(row.nombreprod);
            cantidad_transacciones.push(row.cantidadTransacciones);
        });
        document.getElementById('graphContainer').innerHTML = '<canvas id="chart"></canvas>';
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart', producto, cantidad_transacciones, 'Cantidad:', 'Producto:');
        ABRIR_MODAL_GRAFICA.show();
    } else {
        console.log(JSON.exception);
    }
}

// Metodo para cargar la tabla con los datos de la base
async function rellenarTabla(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PROVEEDOR_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden class="px-6 py-4"">${row.idproveedor}</td>
                    <td class="px-6 py-4">${row.nombreprov}</td>
                    <td class="">${row.telefonoprov}</td>
                    <td class="px-6 py-4">${row.correoprov}</td>
                    <td class="px-6 py-4">${row.codigoprov}</td>
                    <td class="px-6 py-4">${row.codigomaestroprov}</td>
                    <td class="px-6 py-4">${row.duiprov}</td>
                    <td class="px-6 py-4">${row.moneda}</td>
                    <td class="px-6 py-4">${row.numeroregistroprov}</td>
                    <td class="px-6 py-4">
                        <button onclick="actualizarRegistro(${row.idproveedor})"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>

                        <button onclick="eliminarRegistro(${row.idproveedor})"
                        class="md:w-auto text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/delete--v1.png" />
                        </button>

                        <button onclick="abrirGrafica(${row.idproveedor})"
                        class="md:w-auto text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="../resources/img/icons8-reports-58.png" width="31px" height="32px"/>
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
    TITULO.textContent = 'Añadir un nuevo proveedor';
    fillSelect(MONEDA_API, 'leerRegistros', 'moneda');
}

//Funcion para abrir el modal con los datos del registro a actualizar
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PROVEEDOR_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para actualizar un registro 
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar proveedor';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idproveedor;
        document.getElementById('nombre').value = JSON.dataset.nombreprov;
        document.getElementById('telefono').value = JSON.dataset.telefonoprov;
        document.getElementById('correo').value = JSON.dataset.correoprov;
        document.getElementById('codigoProv').value = JSON.dataset.codigoprov;
        document.getElementById('codigoMaestroProv').value = JSON.dataset.codigomaestroprov;
        document.getElementById('dui').value = JSON.dataset.duiprov;
        document.getElementById('numeroRegistroProv').value = JSON.dataset.numeroregistroprov;
        fillSelect(MONEDA_API, 'leerRegistros', 'moneda', JSON.dataset.idmoneda);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Funcion para abrir el modal con los datos del registro a eliminar
async function eliminarRegistro(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const MENSAJE = await confirmAction('¿Desea eliminar el proveedor?');
    // Se verifica la respuesta del mensaje.
    if (MENSAJE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idproveedor', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PROVEEDOR_API, 'eliminarRegistro', FORM);
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