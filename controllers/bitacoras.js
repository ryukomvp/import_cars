// Constante para completar la ruta de la API.
const BITACORAS_API = 'business/bitacoras.php';
// Constante para establecer el formulario de buscar.
const FORMULARIO_BUSQUEDA = document.getElementById('buscarFormulario');
// Constantes para establecer el contenido de la tabla.
const REGISTROS_TABLA = document.getElementById('registros');
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
    const JSON = await dataFetch(BITACORAS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            REGISTROS_TABLA.innerHTML += `
                <tr class="bg-white hover:bg-blue-200">
                    <td class="hidden">${row.idbitacora}</td>
                    <td class="py-3">${row.mensaje}</td>
                    <td class="py-3">${row.fechabitacora}</td>
                </tr>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}