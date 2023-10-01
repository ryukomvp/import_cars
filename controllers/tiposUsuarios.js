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
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));
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
    const JSON = await dataFetch(TIPO_USUARIO_API, action, FORM);
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
            // Se establece una condicion para asignar "Permitido" o "Denegado"
            (row.marcas) ? txtmarcas = 'Permitido' : txtmarcas = 'Denegado';
            (row.paisesdeorigen) ? txtpaises = 'Permitido' : txtpaises = 'Denegado';
            (row.monedas) ? txtmonedas = 'Permitido' : txtmonedas = 'Denegado';
            (row.familias) ? txtfamilias = 'Permitido' : txtfamilias = 'Denegado';
            (row.categorias) ? txtcategorias = 'Permitido' : txtcategorias = 'Denegado';
            (row.codigoscomunes) ? txtcodigoscomunes = 'Permitido' : txtcodigoscomunes = 'Denegado';
            (row.tiposproductos) ? txttiposproductos = 'Permitido' : txttiposproductos = 'Denegado';
            (row.codigostransacciones) ? txtcodigostransacciones = 'Permitido' : txtcodigostransacciones = 'Denegado';
            (row.codigosplazos) ? txtcodigosplazos = 'Permitido' : txtcodigosplazos = 'Denegado';
            (row.sucursales) ? txtsucursales = 'Permitido' : txtsucursales = 'Denegado';
            (row.plazos) ? txtplazos = 'Permitido' : txtplazos = 'Denegado';
            (row.contactos) ? txtcontactos = 'Permitido' : txtcontactos = 'Denegado';
            (row.parametros) ? txtparametros = 'Permitido' : txtparametros = 'Denegado';
            (row.proveedores) ? txtproveedores = 'Permitido' : txtproveedores = 'Denegado';
            (row.modelos) ? txtmodelos = 'Permitido' : txtmodelos = 'Denegado';
            (row.empleados) ? txtempleados = 'Permitido' : txtempleados = 'Denegado';
            (row.clientes) ? txtclientes = 'Permitido' : txtclientes = 'Denegado';
            (row.usuarios) ? txtusuarios = 'Permitido' : txtusuarios = 'Denegado';
            (row.cajas) ? txtcajas = 'Permitido' : txtcajas = 'Denegado';
            (row.cajeros) ? txtcajeros = 'Permitido' : txtcajeros = 'Denegado';
            (row.vendedores) ? txtvendedores = 'Permitido' : txtvendedores = 'Denegado';
            (row.bodegas) ? txtbodegas = 'Permitido' : txtbodegas = 'Denegado';
            (row.familiasbodegas) ? txtfamiliasbodegas = 'Permitido' : txtfamiliasbodegas = 'Denegado';
            (row.productos) ? txtproductos = 'Permitido' : txtproductos = 'Denegado';
            (row.encabezadostransacciones) ? txtencabezadostransacicones = 'Permitido' : txtencabezadostransacicones = 'Denegado';
            (row.detallestransacciones) ? txtdetallestransacciones = 'Permitido' : txtdetallestransacciones = 'Denegado';
            (row.tiposusuarios) ? txttiposusuarios = 'Permitido' : txttiposusuarios = 'Denegado';
            (row.bitacoras) ? txtbitacoras = 'Permitido' : txtbitacoras = 'Denegado';
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
                        ${txtmarcas}
                    </td>
                    <td class="px-6 py-4">
                        ${txtpaises}
                    </td>
                    <td class="px-6 py-4">
                        ${txtmonedas}
                    </td>
                    <td class="px-6 py-4">
                        ${txtfamilias}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcategorias}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcodigoscomunes}
                    </td>
                    <td class="px-6 py-4">
                        ${txttiposproductos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcodigostransacciones}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcodigosplazos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtsucursales}
                    </td>
                    <td class="px-6 py-4">
                        ${txtplazos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcontactos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtparametros}
                    </td>
                    <td class="px-6 py-4">
                        ${txtproveedores}
                    </td>
                    <td class="px-6 py-4">
                        ${txtmodelos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtempleados}
                    </td>
                    <td class="px-6 py-4">
                        ${txtclientes}
                    </td>
                    <td class="px-6 py-4">
                        ${txtusuarios}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcajas}
                    </td>
                    <td class="px-6 py-4">
                        ${txtcajeros}
                    </td>
                    <td class="px-6 py-4">
                        ${txtvendedores}
                    </td>
                    <td class="px-6 py-4">
                        ${txtbodegas}
                    </td>
                    <td class="px-6 py-4">
                        ${txtfamiliasbodegas}
                    </td>
                    <td class="px-6 py-4">
                        ${txtproductos}
                    </td>
                    <td class="px-6 py-4">
                        ${txtencabezadostransacicones}
                    </td>
                    <td class="px-6 py-4">
                        ${txtdetallestransacciones}
                    </td>
                    <td class="px-6 py-4">
                        ${txttiposusuarios}
                    </td>
                    <td class="px-6 py-4">
                        ${txtbitacoras}
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
    ABRIR_MODAL.show();
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
        ABRIR_MODAL.show();
        // Se restauran los elementos del formulario.
        EJECUTAR_FORMULARIO.reset();
        // Texto del boton para crear un registro
        BTN_ACCION.textContent = 'Actualizar';
        // Se asigna título para la caja de diálogo.
        TITULO.textContent = 'Permisos de los tipos de usuarios';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idtipousuario;
        document.getElementById('cargo').value = JSON.dataset.nombretipous;
        // Se verifica si el permiso esta activo o no de marcas
        if (JSON.dataset.marcas == '1') {
            document.getElementById('marca').checked = 1;
        } else {
            document.getElementById('marca').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de paisesdeorigen
        if (JSON.dataset.paisesdeorigen == '1') {
            document.getElementById('paisOrigen').checked = 1;
        } else {
            document.getElementById('paisOrigen').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de monedas
        if (JSON.dataset.monedas == '1') {
            document.getElementById('moneda').checked = 1;
        } else {
            document.getElementById('moneda').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de familias
        if (JSON.dataset.familias == '1') {
            document.getElementById('familia').checked = 1;
        } else {
            document.getElementById('familia').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de categorias
        if (JSON.dataset.categorias == '1') {
            document.getElementById('categoria').checked = 1;
        } else {
            document.getElementById('categoria').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de codigoscomunes
        if (JSON.dataset.codigoscomunes == '1') {
            document.getElementById('codigoComun').checked = 1;
        } else {
            document.getElementById('codigoComun').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de tiposproductos
        if (JSON.dataset.tiposproductos == '1') {
            document.getElementById('tipoProducto').checked = 1;
        } else {
            document.getElementById('tipoProducto').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de codigostransacciones
        if (JSON.dataset.codigostransacciones == '1') {
            document.getElementById('codigoTransac').checked = 1;
        } else {
            document.getElementById('codigoTransac').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de codigosplazos
        if (JSON.dataset.codigosplazos == '1') {
            document.getElementById('codigoPlazo').checked = 1;
        } else {
            document.getElementById('codigoPlazo').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de sucursales
        if (JSON.dataset.sucursales == '1') {
            document.getElementById('sucursal').checked = 1;
        } else {
            document.getElementById('sucursal').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de plazos
        if (JSON.dataset.plazos == '1') {
            document.getElementById('plazo').checked = 1;
        } else {
            document.getElementById('plazo').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de contactos
        if (JSON.dataset.contactos == '1') {
            document.getElementById('contacto').checked = 1;
        } else {
            document.getElementById('contacto').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de parametros
        if (JSON.dataset.parametros == '1') {
            document.getElementById('parametro').checked = 1;
        } else {
            document.getElementById('parametro').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de proveedores
        if (JSON.dataset.proveedores == '1') {
            document.getElementById('proveedor').checked = 1;
        } else {
            document.getElementById('proveedor').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de modelos
        if (JSON.dataset.modelos == '1') {
            document.getElementById('modelo').checked = 1;
        } else {
            document.getElementById('modelo').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de empleados
        if (JSON.dataset.empleados == '1') {
            document.getElementById('empleado').checked = 1;
        } else {
            document.getElementById('empleado').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de clientes
        if (JSON.dataset.clientes == '1') {
            document.getElementById('cliente').checked = 1;
        } else {
            document.getElementById('cliente').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de usuarios
        if (JSON.dataset.usuarios == '1') {
            document.getElementById('usuario').checked = 1;
        } else {
            document.getElementById('usuario').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de cajas
        if (JSON.dataset.cajas == '1') {
            document.getElementById('caja').checked = 1;
        } else {
            document.getElementById('caja').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de cajeros
        if (JSON.dataset.cajeros == '1') {
            document.getElementById('cajero').checked = 1;
        } else {
            document.getElementById('cajero').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de vendedores
        if (JSON.dataset.vendedores == '1') {
            document.getElementById('vendedor').checked = 1;
        } else {
            document.getElementById('vendedor').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de bodegas
        if (JSON.dataset.bodegas == '1') {
            document.getElementById('bodega').checked = 1;
        } else {
            document.getElementById('bodega').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de familiasbodegas
        if (JSON.dataset.familiasbodegas == '1') {
            document.getElementById('familiaBod').checked = 1;
        } else {
            document.getElementById('familiaBod').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de productos
        if (JSON.dataset.productos == '1') {
            document.getElementById('producto').checked = 1;
        } else {
            document.getElementById('producto').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de encabezadostransacciones
        if (JSON.dataset.encabezadostransacciones == '1') {
            document.getElementById('encaTransac').checked = 1;
        } else {
            document.getElementById('encaTransac').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de detallestransacciones
        if (JSON.dataset.detallestransacciones == '1') {
            document.getElementById('detalleTransac').checked = 1;
        } else {
            document.getElementById('detalleTransac').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de tiposusuarios
        if (JSON.dataset.tiposusuarios == '1') {
            document.getElementById('tipoUsuario').checked = 1;
        } else {
            document.getElementById('tipoUsuario').checked = 0;
        }
        // Se verifica si el permiso esta activo o no de bitacoras
        if (JSON.dataset.bitacoras == '1') {
            document.getElementById('bitacora').checked = 1;
        } else {
            document.getElementById('bitacora').checked = 0;
        }
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