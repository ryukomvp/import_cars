
// Constante para la ruta del business que conecta a los metodos del SCRUD
const CODIGO_PLAZO_API = 'business/codigosPlazos.php';
// Constante para el input de busqueda
const FORMULARIO_BUSQUEDA = document.getElementById('buscarFormulario');
// Constante para el formulario del modal, sirve para añadir y editar
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para el formulario del modal, para la grafica
const EJECUTAR_FORMULARIO2 = document.getElementById('ejecutarFormulario2');
// Constante para rellenar la tabla de los datos registrados en la base
const REGISTROS_TABLA = document.getElementById('registros');
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
    const JSON = await dataFetch(CODIGO_PLAZO_API, action, FORM);
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

async function abrirGrafica(idcodigoplazo) {
    const FORM = new FormData();
    FORM.append('idcodigoplazo', idcodigoplazo)
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(CODIGO_PLAZO_API, 'graficaCantidadPlazos', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let plazo = [];
        let cantidad_plazos = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            plazo.push(row.plazo);
            cantidad_plazos.push(row.cantidad_plazos);
        });
        document.getElementById('graphContainer').innerHTML = '<canvas id="chart"></canvas>';
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart', plazo, cantidad_plazos, 'Nombre de codigo', 'Cantidad:');
        ABRIR_MODAL_GRAFICA.show();
    } else {
        console.log(JSON.exception);
    }
 }
// Metodo para cargar la tabla con los datos de la base
async function cargarRegistros(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CODIGO_PLAZO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr  class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden px-6 py-4">${row.idcodigoplazo}</td>
                    <td class="px-6 py-4">${row.plazo}</td>
                    <td class="px-6 py-4">${row.dias}</td>
                    <td class="px-6 py-4">
                        <button onclick="actualizarRegistro(${row.idcodigoplazo})"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>

                        <button onclick="eliminarRegistro(${row.idcodigoplazo})"
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
}

//Funcion para abrir el modal con los datos del registro a actualizar
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CODIGO_PLAZO_API, 'leerUnRegistro', FORM);
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
        document.getElementById('id').value = JSON.dataset.idcodigoplazo;
        document.getElementById('plazo').value = JSON.dataset.plazo;
        document.getElementById('dias').value = JSON.dataset.dias;

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Funcion para abrir el modal con los datos del registro a eliminar
async function eliminarRegistro(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const MENSAJE = await confirmAction('¿Desea eliminar el código del plazo?');
    // Se verifica la respuesta del mensaje.
    if (MENSAJE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idcodigoplazo', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CODIGO_PLAZO_API, 'eliminarRegistro', FORM);
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