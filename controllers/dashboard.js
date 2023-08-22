// Constante para completar la ruta de la API.
const CAJERO_API = 'business/cajeros.php';
const FAMILIABODEGA_API = 'business/familiasbodegas.php';
const ENCATRANSACCIONES_API = 'business/encabezadosTransacciones.php';
const EMPLEADOS_API = 'business/empleados.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoPolarClientes();
    graficoRadarFamilias();
    graficoBodegasTransacciones();
    graficoEmpleadosCargos();
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

// Grafico para mostrar las bodegas asignadas en cada transaccion
async function graficoBodegasTransacciones() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(ENCATRANSACCIONES_API, 'transacBodegas');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let bodega = [];
        let transacciones = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            bodega.push(row.numerobod);
            transacciones.push(row.idencatransaccion);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        lineGraph('transaccionBodegasGrafic', bodega, transacciones, 'CANTIDAD DE TRANSACCIONES EN ESTA BODEGA', '');
    } else {
        document.getElementById('transaccionBodegasGrafic').remove();
        console.log(DATA.exception);
    }
  
  }
  
  // Grafico para mostrar la cantidad de empleados por cargo
async function graficoEmpleadosCargos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(EMPLEADOS_API, 'empleadosCargos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let idempleado = [];
        let cargo = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            idempleado.push(row.idempleado);
            cargo.push(row.cargo);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('empleadoCargo', cargo, idempleado ,'');
    } else {
        document.getElementById('empleadoCargo').remove();
        console.log(DATA.exception);
    }
  
  }