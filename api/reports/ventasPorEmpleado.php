<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idempleado'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/empleados.php');

    // Se instancian las entidades correspondientes.
    $empleado = new empleados;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($empleado->setIdempleado($_GET['idempleado'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowEmpleado = $empleado->leerUnEmpleado()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Ventas de el empleado ' . $rowEmpleado['nombreemp']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataDetalle = $empleado->ventasPorEmpleado()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(80, 10, 'Fecha', 1, 0, 'C', 1);
                $pdf->cell(66, 10, 'Cantidad de producto vendido', 1, 0, 'C', 1);
                $pdf->cell(41, 10, 'Precio unitario (US$)', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataDetalle as $rowDetalle) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(80, 10, $rowDetalle['fechatransac'], 1, 0);
                    $pdf->cell(66, 10, $rowDetalle['cantidad'], 1, 0);
                    $pdf->cell(41, 10, $rowDetalle['preciounitario'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay ventas de el empleado que selecciono '), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Ventas_empleado.pdf');
        } else {
            print('No tiene ventas este empleado');
        }
    } else {
        print('Empleado incorrecta');
    }
} else {
    print('Debe seleccionar una empleado');
}
