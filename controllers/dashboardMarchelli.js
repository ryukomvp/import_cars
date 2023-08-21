const ENCATRANSACCIONES_API = 'business/encabezadosTransacciones.php';
const EMPLEADOS_API = 'business/empleados.php';

document.addEventListener('DOMContentLoaded', () => {
  // SLasSe llaman las funciones de las graficas para cargarlas con los datos.
  graficoBodegasTransacciones();
  graficoEmpleadosCargos();
});


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