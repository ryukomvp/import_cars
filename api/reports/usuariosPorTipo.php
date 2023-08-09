<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/products.php');
require_once('../../entities/dto/categories.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Usuarios por tipo');
// Se instancia el módelo Categoría para obtener los datos.
$categoria = new Category;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $categoria->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(46.5, 10, 'Usuario', 1, 0, 'C', 1);
    $pdf->cell(46.5, 10, 'Empleado', 1, 0, 'C', 1);
    $pdf->cell(46.5, 10, 'Estado', 1, 1, 'C', 1);
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCategorias as $rowCategoria) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Tipo de usuario: ' . $rowCategoria['categoria']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $producto = new Product;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setCategoria($rowCategoria['tipousuario'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['usuario']), 1, 0);
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['empleado']), 1, 0);
                    $pdf->cell(46.5, 10, $rowProducto['estadousuario'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay usuarios para el tipo'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Tipo incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay tipos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'usuarios_tipo.pdf');