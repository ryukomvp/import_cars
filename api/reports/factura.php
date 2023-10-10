<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../entities/dto/marcas.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Factura');
// Se instancia el módelo Categoría para obtener los datos.
$marca = new marca;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(230);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen los encabezados con los encabezados.
    // Encabezado de categoria
    $pdf->cell(186, 10, 'IMPORT CARS, S.A DE C.V', 0, 1, 'C', 0);
    $pdf->cell(62, 10, 'Giro', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Direccion y Sucursal', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Factura', 0, 1, 'C', 0) ;
    $pdf->cell(186, 10, 'Correo', 0, 1, 'C', 0);
    $pdf->cell(62, 10, 'Cliente', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'DUI/NIT', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Vendedor', 0, 1, 'C', 0);
    $pdf->cell(62, 10, 'Direccion', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Municipio', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Departamento', 0, 1, 'C', 0);
    $pdf->cell(62, 10, 'Condicion de pago', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Caja', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Cajero', 0, 1, 'C', 0);

    $pdf->setFillColor(230);
    $pdf->setFont('Times', 'B', 11);
    $pdf->cell(186, 5, '', 0, 1, 'C', 0);
    $pdf->cell(20, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->cell(20, 10, 'Codigo', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Descripcion', 1, 0, 'C', 1);
    $pdf->cell(20, 10, 'Precio U.', 1, 0, 'C', 1);
    $pdf->cell(22, 10, 'V. no sujetas', 1, 0, 'C', 1);
    $pdf->cell(22, 10, 'V. exentas', 1, 0, 'C', 1);
    $pdf->cell(22, 10, 'V. afectas', 1, 1, 'C', 1);

    $pdf->cell(186, 15, '', 0, 1, 'C', 0);
    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Descuento', 1, 1, 'C', 1);

    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Suma', 1, 1, 'C', 1);

    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Sub - Total', 1, 1, 'C', 1);

    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, '', 0, 0, 'C', 0);
    $pdf->cell(62, 10, 'Venta Total', 1, 1, 'C', 1);
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'factura.pdf');