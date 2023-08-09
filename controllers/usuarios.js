// Constante para establecer el formulario de buscar.
const FORMULARIO_BUSQUEDA = document.getElementById('buscarFormulario');
// Constante para establecer el formulario de guardar.
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para establecer el título de la modal.
const TITULO = document.getElementById('titulo');
// Constantes para establecer el contenido de la tabla.
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Constante para capturar el modal.
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    registrosTabla();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
FORMULARIO_BUSQUEDA.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_BUSQUEDA);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    registrosTabla(FORM);
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
    const JSON = await dataFetch(USUARIO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        registrosTabla();
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
async function registrosTabla(form = null) {
    // Se inicializa el contenido de la tabla.
    REGISTROS_TABLA.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'buscarRegistros' : action = 'leerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-200 dark:hover:bg-gray-600">
                    <td>${row.usuario}</td>
                    <td>${row.pin}</td>
                    <td>${row.tipousuario}</td>
                    <td>${row.empleado}</td>
                    <td>${row.estadousuario}</td>
                    <td>
                        <button onclick="actualizarRegistro(${row.idusuario})"
                            class="text-blue-700 border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/1A56DB/synchronize.png" />
                        </button>
                        <button onclick="eliminarRegistro(${row.idusuario})"  
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
function crearRegistro() {
    // Se abre la caja de diálogo que contiene el formulario.
    ABRIR_MODAL.show();
    // Se restauran los elementos del formulario.
    EJECUTAR_FORMULARIO.reset();
    // Se asigna título a la caja de diálogo.
    TITULO.textContent = 'Añadir nuevo usuario';
    // Se asigna texto al botón de acción.
    BTN_ACCION.textContent = 'Añadir';
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
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        ABRIR_MODAL.show();
        // Se restauran los elementos del formulario.
        EJECUTAR_FORMULARIO.reset();
        // Se asigna título a la caja de diálogo.
        TITULO.textContent = 'Actualizar usuario';
        // Se asigna texto al botón de acción.
        BTN_ACCION.textContent = 'Actualizar';
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
        const JSON = await dataFetch(USUARIO_API, 'eliminarRegistro', FORM);
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