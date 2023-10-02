<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../entities/dto/detallesTransacciones.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Transacciones');
// Se instancia el módelo Categoría para obtener los datos.
$detalletransaccion = new DetallesTransacciones;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProveedores = $detalletransaccion->leerRegistros()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen los encabezados con los encabezados.
    // Encabezado de categoria
    $pdf->cell(93, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Descripción', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Precio Unitario', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Descuento', 1, 1, 'C', 1);
    $pdf->cell(93, 10, 'Sub Total', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Total', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'IVA', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Observaciones', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Bodega de Entrada', 1, 0, 'C', 1);
    $pdf->cell(93, 10, 'Bodega de Salida', 1, 0, 'C', 0);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de las categorias.
    $pdf->setFont('Times', 'B', 11);
    // Se recorren los registros fila por fila.
    foreach ($dataProveedores as $rowProveedores) {
        // Se imprimen las celdas con los datos de las categorias.
        // Celda de categoria
        $pdf->cell(93, 10, $pdf->encodeString($rowProveedores['nombreprov']), 1, 0);
        $pdf->cell(93, 10, $pdf->encodeString($rowProveedores['correoprov']), 1, 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay proveedores para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'proveedores.pdf');