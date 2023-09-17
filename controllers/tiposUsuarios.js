// Constante para completar la ruta de la API.
const TIPO_USUARIO_API = 'business/tiposUsuarios.php';

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
    const JSON = await dataFetch(TIPO_USUARIO_API, action, FORM);
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
    const JSON = await dataFetch(TIPO_USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="text-center bg-white hover:bg-blue-200">
                    <td class="hidden px-6 py-4">
                        ${row.idtipousuario}
                    </td>
                    <td class="px-6 py-4">
                        ${row.nombretipous}
                    </td>
                    <td class="px-6 py-4">
                        ${row.marcas}
                    </td>
                    <td class="px-6 py-4">
                        ${row.paisesdeorigen}
                    </td>
                    <td class="px-6 py-4">
                        ${row.monedas}
                    </td>
                    <td class="px-6 py-4">
                        ${row.familias}
                    </td>
                    <td class="px-6 py-4">
                        ${row.categorias}
                    </td>
                    <td class="px-6 py-4">
                        ${row.codigoscomunes}
                    </td>
                    <td class="px-6 py-4">
                        ${row.tiposproductos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.codigostransacciones}
                    </td>
                    <td class="px-6 py-4">
                        ${row.codigosplazos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.sucursales}
                    </td>
                    <td class="px-6 py-4">
                        ${row.plazos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.contactos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.parametros}
                    </td>
                    <td class="px-6 py-4">
                        ${row.proveedores}
                    </td>
                    <td class="px-6 py-4">
                        ${row.modelos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.empleados}
                    </td>
                    <td class="px-6 py-4">
                        ${row.clientes}
                    </td>
                    <td class="px-6 py-4">
                        ${row.usuarios}
                    </td>
                    <td class="px-6 py-4">
                        ${row.cajas}
                    </td>
                    <td class="px-6 py-4">
                        ${row.cajeros}
                    </td>
                    <td class="px-6 py-4">
                        ${row.vendedores}
                    </td>
                    <td class="px-6 py-4">
                        ${row.bodegas}
                    </td>
                    <td class="px-6 py-4">
                        ${row.familiasbodegas}
                    </td>
                    <td class="px-6 py-4">
                        ${row.productos}
                    </td>
                    <td class="px-6 py-4">
                        ${row.encabezadostransacciones}
                    </td>
                    <td class="px-6 py-4">
                        ${row.detallestransacciones}
                    </td>
                    <td class="px-6 py-4">
                        ${row.tiposusuarios}
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="actualizarRegistro(${row.idtipousuario})"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <img src="https://img.icons8.com/ios/30/FFFFFF/synchronize.png" />
                        </button>
                        <button onclick="eliminarRegistrote(${row.idtipousuario})"
                            class="hidden md:w-auto text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
    ACCIONES_MODAL.show();
    // Se restauran los elementos del formulario.
    EJECUTAR_FORMULARIO.reset();
    // Texto del boton para crear un registro
    BTN_ACCION.textContent = 'Añadir';
    // Se asigna título a la caja de diálogo.
    TITULO.textContent = 'Crear un registro';
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
    const JSON = await dataFetch(TIPO_USUARIO_API, 'leerUnRegistro', FORM);
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
        document.getElementById('id').value = JSON.dataset.idtipousuario;
        document.getElementById('cargo').value = JSON.dataset.nombretipous;
        document.getElementById('marca').value = JSON.dataset.marcas;
        document.getElementById('paisOrigen').value = JSON.dataset.paisesdeorigen;
        document.getElementById('moneda').value = JSON.dataset.monedas;
        document.getElementById('familia').value = JSON.dataset.familias;
        document.getElementById('categoria').value = JSON.dataset.categorias;
        document.getElementById('codigoComun').value = JSON.dataset.codigoscomunes;
        document.getElementById('tipoProducto').value = JSON.dataset.tiposproductos;
        document.getElementById('codigoTransac').value = JSON.dataset.codigostransacciones;
        document.getElementById('codigoPlazo').value = JSON.dataset.codigosplazos;
        document.getElementById('sucursal').value = JSON.dataset.sucursales;
        document.getElementById('plazo').value = JSON.dataset.plazos;
        document.getElementById('contacto').value = JSON.dataset.contactos;
        document.getElementById('parametro').value = JSON.dataset.parametros;
        document.getElementById('proveedor').value = JSON.dataset.proveedores;
        document.getElementById('modelo').value = JSON.dataset.modelos;
        document.getElementById('empleado').value = JSON.dataset.empleados;
        document.getElementById('cliente').value = JSON.dataset.clientes;
        document.getElementById('usuario').value = JSON.dataset.usuarios;
        document.getElementById('caja').value = JSON.dataset.cajas;
        document.getElementById('cajero').value = JSON.dataset.cajeros;
        document.getElementById('vendedor').value = JSON.dataset.vendedores;
        document.getElementById('bodega').value = JSON.dataset.bodegas;
        document.getElementById('familiaBod').value = JSON.dataset.familiasbodegas;
        document.getElementById('producto').value = JSON.dataset.productos;
        document.getElementById('encaTransac').value = JSON.dataset.encabezadostransacciones;
        document.getElementById('detalleTransac').value = JSON.dataset.detallestransacciones;
        document.getElementById('tipoUsuario').value = JSON.dataset.tiposusuarios;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function eliminarRegistrote(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el tipo de usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idtipousuario', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(TIPO_USUARIO_API, 'eliminarRegistro', FORM);
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