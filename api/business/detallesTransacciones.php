<?php
require_once('../entities/dto/detallesTransacciones.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $detalleTrans = new DetallesTransacciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'cantidadCantidadTransaccion':
                if ($result['dataset'] = $detalleTrans->cantidadCantidadTransaccion()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $detalleTrans->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $detalleTrans->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$detalleTrans->setCorrelativo($_POST['correlativo'])) {
                    $result['exception'] = 'Correlativo incorrecto';
                } elseif (!$detalleTrans->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad de productos incorrecta';
                } elseif (!$detalleTrans->setPrecioUnitario($_POST['precioUnitario'])) {
                    $result['exception'] = 'LPrecio unitario incorrecto';
                } elseif (!$detalleTrans->setVentaNoSujeta($_POST['ventaNoSujeta'])) {
                    $result['exception'] = 'Venta no sujeta incorrecta';
                } elseif (!$detalleTrans->setVentaExenta($_POST['ventaExenta'])) {
                    $result['exception'] = 'Venta exenta incorrecta';
                } elseif (!$detalleTrans->setVentaAfecta($_POST['ventaAfecta'])) {
                    $result['exception'] = 'Venta afecta incorrecta';
                } elseif (!$detalleTrans->setDescuento($_POST['descuento'])) {
                    $result['exception'] = 'Descuento incorrecto';
                } elseif (!$detalleTrans->setValorDescuento($_POST['valorDescuento'])) {
                    $result['exception'] = 'Valor del descuento incorrecto';
                } elseif (!$detalleTrans->setSumas($_POST['suma'])) {
                    $result['exception'] = 'Sumatoria de los precios de los productos incorrecto';
                } elseif (!$detalleTrans->setSubTotal($_POST['subTotal'])) {
                    $result['exception'] = 'Sut total incorrecto';
                } elseif (!$detalleTrans->setVentaTotal($_POST['ventaTotal'])) {
                    $result['exception'] = 'Venta total incorrecta';
                } elseif (!$detalleTrans->setIva($_POST['iva'])) {
                    $result['exception'] = 'IVA asignado incorrecto';
                } elseif (!$detalleTrans->setObservacion($_POST['observaciones'])) {
                    $result['exception'] = 'Observación incorrecta';
                } elseif (!$detalleTrans->setIdBodegaEntrada($_POST['bodegaEntrada'])) {
                    $result['exception'] = 'Error al asignar la bodega de entrada del articulo';
                } elseif (!$detalleTrans->setIdBodegaSalida($_POST['bodegaSalida'])) {
                    $result['exception'] = 'Error al asignar la bodega de salida del articulo';
                } elseif (!$detalleTrans->setIdProducto($_POST['producto'])) {
                    $result['exception'] = 'Error al asignar el producto';
                } elseif (!$detalleTrans->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$detalleTrans->setIdEncatraccion($_POST['encaTransaccion'])) {
                    $result['exception'] = 'Error al asignar el encabezado de la transacción';
                } elseif ($detalleTrans->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle de la transacción creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $detalleTrans->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$detalleTrans->setId($_POST['id'])) {
                    $result['exception'] = 'Transacción incorrecta';
                } elseif ($result['dataset'] = $detalleTrans->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Detalle inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$detalleTrans->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $detalleTrans->leerUnRegistro()) {
                    $result['exception'] = 'Código de transacción inexistente';
                } elseif (!$detalleTrans->setCorrelativo($_POST['correlativo'])) {
                    $result['exception'] = 'Correlativo incorrecto';
                } elseif (!$detalleTrans->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad de productos incorrecta';
                } elseif (!$detalleTrans->setPrecioUnitario($_POST['precioUnitario'])) {
                    $result['exception'] = 'LPrecio unitario incorrecto';
                } elseif (!$detalleTrans->setVentaNoSujeta($_POST['ventaNoSujeta'])) {
                    $result['exception'] = 'Venta no sujeta incorrecta';
                } elseif (!$detalleTrans->setVentaExenta($_POST['ventaExenta'])) {
                    $result['exception'] = 'Venta exenta incorrecta';
                } elseif (!$detalleTrans->setVentaAfecta($_POST['ventaAfecta'])) {
                    $result['exception'] = 'Venta afecta incorrecta';
                } elseif (!$detalleTrans->setDescuento($_POST['descuento'])) {
                    $result['exception'] = 'Descuento incorrecto';
                } elseif (!$detalleTrans->setValorDescuento($_POST['valorDescuento'])) {
                    $result['exception'] = 'Valor del descuento incorrecto';
                } elseif (!$detalleTrans->setSumas($_POST['suma'])) {
                    $result['exception'] = 'Sumatoria de los precios de los productos incorrecto';
                } elseif (!$detalleTrans->setSubTotal($_POST['subTotal'])) {
                    $result['exception'] = 'Sut total incorrecto';
                } elseif (!$detalleTrans->setVentaTotal($_POST['ventaTotal'])) {
                    $result['exception'] = 'Venta total incorrecta';
                } elseif (!$detalleTrans->setIva($_POST['iva'])) {
                    $result['exception'] = 'IVA asignado incorrecto';
                } elseif (!$detalleTrans->setObservacion($_POST['observaciones'])) {
                    $result['exception'] = 'Observación incorrecta';
                } elseif (!$detalleTrans->setIdBodegaEntrada($_POST['bodegaEntrada'])) {
                    $result['exception'] = 'Error al asignar la bodega de entrada del articulo';
                } elseif (!$detalleTrans->setIdBodegaSalida($_POST['bodegaSalida'])) {
                    $result['exception'] = 'Error al asignar la bodega de salida del articulo';
                } elseif (!$detalleTrans->setIdProducto($_POST['producto'])) {
                    $result['exception'] = 'Error al asignar el producto';
                } elseif (!$detalleTrans->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$detalleTrans->setIdEncatraccion($_POST['encaTransaccion'])) {
                    $result['exception'] = 'Error al asignar el encabezado de la transacción';
                } elseif ($detalleTrans->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle de la transacción actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$detalleTrans->setId($_POST['iddetalletransaccion'])) {
                    $result['exception'] = 'Detalle de la transaccion incorrecto';
                } elseif (!$data = $detalleTrans->leerUnRegistro()) {
                    $result['exception'] = 'Detalle de la transacción inexistente';
                } elseif ($detalleTrans->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle de la transacción eliminado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
