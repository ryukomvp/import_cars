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