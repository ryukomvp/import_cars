<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idcategoria'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/categorias.php');
    require_once('../entities/dto/productos.php');
    // Se instancian las entidades correspondientes.
    $categoria = new Categoria;
    $producto = new Productos;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($categoria->setId($_GET['idcategoria']) && $producto->setCategoria($_GET['idcategoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCategoria = $categoria->leerRegistros()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la categoría ' . $rowCategoria['categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(46.5, 10, 'nombre', 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, 'precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, $pdf->encodeString('categoría'), 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, $pdf->encodeString('modelo'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['nombreprod']), 1, 0);
                    $pdf->cell(46.5, 10, $rowProducto['precio'], 1, 0);
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['categoria']), 1, 0);
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['modelo']), 1, 0);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría seleccionada'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'productos_categoria.pdf');
        } else {
            print('Categoría inexistente');
        }
    } else {
        print('Categoría incorrecta');
    }
} else {
    print('Debe seleccionar una categoría');
}
