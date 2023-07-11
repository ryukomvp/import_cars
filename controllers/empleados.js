// Constante para la ruta del business que conecta a los metodos del SCRUD
const EMPLEADO_API = 'business/empleados.php';
// Constante para el input de busqueda
const BUSCAR_FORMULARIO = document.getElementById('buscarFormulario');
// Constante para el formulario del modal, sirve para añadir y editar
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para rellenar la tabla de los datos registrados en la base
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Constante para nombrar el modal dependiendo de la acción que se haga
const TITULO = document.getElementById('titulo');
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Constante para abrir o cerrar el modal
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));

// Metodo para cargar la pagina cada vez que haya un cambio en el DOM
document.addEventListener('DOMContentLoaded', () => {
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
    (document.getElementById('id').value) ? action = 'actualizarEmpleado' : action = 'crearEmpleado';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(EMPLEADO_API, action, FORM);
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

// Metodo para cargar la tabla con los datos de la base
async function rellenarTabla(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarEmpleado' : action = 'leerEmpleados';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(EMPLEADO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr  class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden">${row.idempleado}</td>
                    <td>${row.nombre}</td>
                    <td>${row.telefono}</td>
                    <td>${row.correo}</td>
                    <td>${row.nacimiento}</td>
                    <td>${row.documento}</td>
                    <td>${row.estadoempleado}</td>
                    <td>${row.genero}</td>
                    <td>${row.cargo}</td>
                    <td>
                        <button onclick="actualizarRegistro(${row.idempleado})"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>

                        <button onclick="eliminarRegistro(${row.idempleado})"
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
    TITULO.textContent = 'Añadir un nuevo empleado';
    //fillSelect(MONEDA_API, 'leerMonedas', 'moneda');
    fillSelect(EMPLEADO_API, 'leerEstadosEmpleados', 'estado');
    fillSelect(EMPLEADO_API, 'leerGeneros', 'genero');
    fillSelect(EMPLEADO_API, 'leerCargos', 'cargo');
}

//Funcion para abrir el modal con los datos del registro a actualizar
async function actualizarRegistro(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(EMPLEADO_API, 'leerUnEmpleado', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        EJECUTAR_FORMULARIO.reset();
         // Texto del boton para actualizar un registro 
         BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Actualizar empleado';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idempleado;
        document.getElementById('nombre').value = JSON.dataset.nombre;
        document.getElementById('telefono').value = JSON.dataset.telefono;
        document.getElementById('correo').value = JSON.dataset.correo;
        document.getElementById('nacimiento').value = JSON.dataset.nacimiento;
        document.getElementById('documento').value = JSON.dataset.documento;
        fillSelect(EMPLEADO_API, 'leerEstadosEmpleados', 'estado', JSON.dataset.estadoempleado);
        fillSelect(EMPLEADO_API, 'leerGeneros', 'genero', JSON.dataset.genero);
        fillSelect(EMPLEADO_API, 'leerCargos', 'cargo', JSON.dataset.cargos);
        //document.getElementById('numeroRegistroProv').value = JSON.dataset.numeroregistroprov;
        //fillSelect(MONEDA_API, 'leerMonedas', 'moneda', JSON.dataset.idmoneda);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Funcion para abrir el modal con los datos del registro a eliminar
async function eliminarRegistro(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const MENSAJE = await confirmAction('¿Desea eliminar el empleado?');
    // Se verifica la respuesta del mensaje.
    if (MENSAJE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idempleado', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(EMPLEADO_API, 'eliminarEmpleado', FORM);
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