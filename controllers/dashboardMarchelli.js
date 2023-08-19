const ENCATRANSACCIONES_API = 'business/encabezadosTransacciones.php';

document.addEventListener('DOMContentLoaded', () => {
  // SLasSe llaman las funciones de las graficas para cargarlas con los datos.
  graficoBodegasTransacciones();
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
            transacciones.push(row.nocomprobante);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        lineGraph('transaccionBodegasGrafic', transacciones, bodega, 'BODEGA', 'TRANSACCIONES');
    } else {
        document.getElementById('transaccionBodegasGrafic').remove();
        console.log(DATA.exception);
    }
  
  }
  