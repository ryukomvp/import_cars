// Constante para completar la ruta de la API.
const CAJERO_API = 'business/cajeros.php';
const FAMILIABODEGA_API = 'business/familiasbodegas.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoPolarClientes();
    graficoRadarFamilias();
});

/*
*   Función asíncrona para mostrar en un gráfico polor mostrando la cantidad de cajeros por caja.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoPolarClientes() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(CAJERO_API, 'cantidadCajerosCajas');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let cajas = [];
        let cajeros = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            cajas.push(row.idcaja);
            cajeros.push(row.cajeros);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('cajerosPorCaja', cajas, cajeros, 'Cantidad de cajeros asignados a una caja');
    } else {
        document.getElementById('cajerosPorCajas').remove();
        console.log(JSON.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de dona paramostrar la cantidad de productos subidos por un usuario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoRadarFamilias() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(FAMILIABODEGA_API, 'cantidadFamiliaBodega');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let bodegas = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            bodegas.push(row.bodegas);
            cantidad.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        pieGraph('familiasPorBodega', bodegas, cantidad, 'Cantidad de familias que se encuentran en la bodega');
    } else {
        document.getElementById('familiasPorBodega').remove();
        console.log(JSON.exception);
    }
}