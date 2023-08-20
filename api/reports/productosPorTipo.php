<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idtipoproducto'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/tiposProductos.php');
    require_once('../entities/dto/productos.php');
    // Se instancian las entidades correspondientes.
    $tipo = new TiposProductos;
    $producto = new Productos;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($tipo->setId($_GET['idtipoproducto']) && $producto->setTipoProducto($_GET['idtipoproducto'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowTipo = $tipo->leerUnRegistro()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de el tipo  ' . $rowTipo['tipoproducto']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $tipo->productosTipo()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(88, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(33, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(33, 10, $pdf->encodeString('Tipo producto'), 1, 0, 'C', 1);
                $pdf->cell(33, 10, $pdf->encodeString('Categoria'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(88, 10, $rowProducto['nombreprod'], 1, 0);
                    $pdf->cell(33, 10, $rowProducto['precio'], 1, 0);
                    $pdf->cell(33, 10, $pdf->encodeString($rowProducto['tipoproducto']), 1, 0);
                    $pdf->cell(33, 10, $pdf->encodeString($rowProducto['categoria']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el tipo de producto seleccionado'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'productos_tipos.pdf');
        } else {
            print('Tipo de prodcuto inexistente');
        }
    } else {
        print('Tipo de producto incorrecta');
    }
} else {
    print('Debe seleccionar un tipo de producto');
}
