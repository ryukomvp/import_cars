<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se captura el id de la factura imprimida
// if (isset($_GET['idfactura']) OR !($_GET['idfactura'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/facturas.php');
    // Se instancia el módelo Categoría para obtener los datos.
    $factura = new Facturas;
    if ($dataFactura = $factura->leerUnRegistro()) {
        // Se inicia el reporte con el encabezado del documento.
        $pdf->startReport('Factura');
        // Se establece un color de relleno para los encabezados.
        $pdf->setFillColor(230);
        // Se establece la fuente para los encabezados.
        $pdf->setFont('Times', 'B', 11);
        // Se imprimen los encabezados con los encabezados.
        // Encabezado de categoria
        $pdf->cell(186, 10, 'IMPORT CARS, S.A DE C.V', 0, 1, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['creditosfiscales.giro']), 1, 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['nombresucdireccion'],), 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['facturas.nofactura']), 0, 1, 'C', 0);
        $pdf->cell(186, 10, $pdf->encodeString($dataFactura['facturas.gmail']), 0, 1, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['clientes.nombre']), 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['clientes.dui']), 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['empleados.nombreemp']), 0, 1, 'C', 0);
        $pdf->cell(62, 10, 'Direccion', 0, 0, 'C', 0);
        $pdf->cell(62, 10, 'Municipio', 0, 0, 'C', 0);
        $pdf->cell(62, 10, 'Departamento', 0, 1, 'C', 0);
        $pdf->cell(62, 10, 'Condicion de pago', 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['cajas.nombrecaja']), 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['cajeros.nombrecajero']), 0, 1, 'C', 0);

        $pdf->setFillColor(230);
        $pdf->setFont('Times', 'B', 11);
        $pdf->cell(186, 5, '', 0, 1, 'C', 0);
        $pdf->cell(20, 10, 'Cantidad', 1, 0, 'C', 1);
        $pdf->cell(20, 10, 'Codigo', 1, 0, 'C', 1);
        $pdf->cell(60, 10, $pdf->encodeString('Descripción'), 1, 0, 'C', 1);
        $pdf->cell(20, 10, 'Precio U.', 1, 0, 'C', 1);
        $pdf->cell(22, 10, 'V. no sujetas', 1, 0, 'C', 1);
        $pdf->cell(22, 10, 'V. exentas', 1, 0, 'C', 1);
        $pdf->cell(22, 10, 'V. afectas', 1, 1, 'C', 1);
        // Se establece un color de relleno para mostrar el nombre de la categoría.
        $pdf->setFillColor(225);
        // Se establece la fuente para los datos de las categorias.
        $pdf->setFont('Times', 'B', 11);
        // Se recorren los registros fila por fila.
        foreach ($dataFactura as $rowFactura) {
            // Se imprimen las celdas con los datos de las categorias.
            // Celda de los datos del producto y precios
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['detallestransacciones.cantidad']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['productos.nombreprod']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['productos.descripcionprod']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['detallestransacciones.preciounitario']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['detallestransacciones.ventasnosujetas']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['detallestransacciones.ventasexentas']), 1, 0);
            $pdf->cell(93, 10, $pdf->encodeString($rowFactura['detallestransacciones.ventasafectas']), 1, 1);
        }
        $pdf->cell(186, 15, '', 0, 1, 'C', 0);
        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['detallestransacciones.descuento']), 1, 1, 'C', 1);

        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['encabezadostransacciones.suma']), 1, 1, 'C', 1);

        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['encabezadostransacciones.subtotal']), 1, 1, 'C', 1);

        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, '', 0, 0, 'C', 0);
        $pdf->cell(62, 10, $pdf->encodeString($dataFactura['encabezadostransacciones.ventatotal']), 1, 1, 'C', 1);
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('No hay detalles de la factura'), 1, 1);
    }
    // Se llama implícitamente al método footer() y se envía el documento al navegador web.
    $pdf->output('I', 'factura.pdf');
// } else {
//     print('Debe seleccionar una factura');
// }
