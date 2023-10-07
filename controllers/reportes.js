/*
*   Función para abrir el reporte de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function usuariosTipo() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/usuariosPorTipo.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

// Reportes generales
/*
*   Función para abrir el reporte de empleados.
*/

function empleados() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/empleados.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

/*
*   Función para abrir el reporte de marcas.
*/

function marcas() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/marcas.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

/*
*   Función para abrir el reporte de proveedores.
*/

function proveedores() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/proveedores.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function transaccionesVentas() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/transaccionesVentas.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function transaccionesIngresos() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/transaccionesIngresos.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function transaccionesTraspasos() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/transaccionesTraspasos.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}