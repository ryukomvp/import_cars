<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idmarca'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/marcas.php');
    // Se instancian las entidades correspondientes.
    $marcas = new Marca;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($marcas->setId($_GET['idmarca'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowMarcas = $marcas->leerUnRegistro()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la marca: ' . $rowMarcas['marca']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $marcas->productosMarca()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(93, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(31, 10, 'Tipo', 1, 0, 'C', 1);
                $pdf->cell(31, 10, $pdf->encodeString('Categoría'), 1, 0, 'C', 1);
                $pdf->cell(31, 10, 'Modelo', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(93, 10, $pdf->encodeString($rowProducto['nombreprod']), 1, 0);
                    $pdf->cell(31, 10, $rowProducto['tipoproducto'], 1, 0);
                    $pdf->cell(31, 10, $pdf->encodeString($rowProducto['categoria']), 1, 0);
                    $pdf->cell(31, 10, $pdf->encodeString($rowProducto['modelo']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la marca seleccionada'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'productos_marca.pdf');
        } else {
            print('Marca inexistente');
        }
    } else {
        print('Marca incorrecta');
    }
} else {
    print('Debe seleccionar una marca');
}
