<?php
require_once('../entities/dto/encabezadosTransacciones.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $encabezadoTransac = new Encabezado;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $encabezadoTransac->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $encabezadoTransac->buscarRegistros($_POST['buscar'])) {
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
                if (!$encabezadoTransac->setNoComprobante($_POST['noComprobante'])) {
                    $result['exception'] = 'Número de comprobante incorrecto';
                } elseif(!$encabezadoTransac->setFechaTransac($S_POST['fechaTransac'])){
                    $result['exception'] = 'Fecha de la transacción incorrecta';
                } elseif(!$encabezadoTransac->setLote($S_POST['lote'])){
                    $result['exception'] = 'Lote asignado incorrecto';
                } elseif(!$encabezadoTransac->setNoPoliza($S_POST['nopoliza'])){
                    $result['exception'] = 'Número de poliza incorrecto';
                } elseif(!$encabezadoTransac->setIdBodega($S_POST['bodega'])){
                    $result['exception'] = 'Error al asignar la bodega';
                } elseif(!$encabezadoTransac->setIdCajero($S_POST['cajero'])){
                    $result['exception'] = 'Error al asignar el cajero';
                } elseif(!$encabezadoTransac->setTipoPago($S_POST['tipoPago'])){
                    $result['exception'] = 'Error al asignar el tipo de pago';
                } elseif(!$encabezadoTransac->setIdCodigoTransaccion($S_POST['codigoTransaccion'])){
                    $result['exception'] = 'Error al asignar el código de la transacción';
                } elseif(!$encabezadoTransac->setIdCliente($S_POST['cliente'])){
                    $result['exception'] = 'Error al asignar el cliente';
                } elseif(!$encabezadoTransac->setIdVendedor($S_POST['vendedor'])){
                    $result['exception'] = 'Error al asignar el vendedor';
                } elseif(!$encabezadoTransac->setIdProveedor($S_POST['proveedor'])){
                    $result['exception'] = 'Error al asignar el proveedor';
                } elseif(!$encabezadoTransac->setIdParametro($S_POST['parametro'])){
                    $result['exception'] = 'Error al asignar el parámetro';
                } elseif ($encabezadoTransac->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Encabezado de la transacción creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $encabezadoTransac->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$encabezadoTransac->setId($_POST['id'])) {
                    $result['exception'] = 'Encabezado incorrecto';
                } elseif ($result['dataset'] = $encabezadoTransac->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Encabezado inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$encabezadoTransac->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $encabezadoTransac->leerUnRegistro()) {
                    $result['exception'] = 'Código de transacción inexistente';
                } elseif (!$encabezadoTransac->setNoComprobante($_POST['noComprobante'])) {
                    $result['exception'] = 'Número de comprobante incorrecto';
                } elseif(!$encabezadoTransac->setFechaTransac($S_POST['fechaTransac'])){
                    $result['exception'] = 'Fecha de la transacción incorrecta';
                } elseif(!$encabezadoTransac->setLote($S_POST['lote'])){
                    $result['exception'] = 'Lote asignado incorrecto';
                } elseif(!$encabezadoTransac->setNoPoliza($S_POST['nopoliza'])){
                    $result['exception'] = 'Número de poliza incorrecto';
                } elseif(!$encabezadoTransac->setIdBodega($S_POST['bodega'])){
                    $result['exception'] = 'Error al asignar la bodega';
                } elseif(!$encabezadoTransac->setIdCajero($S_POST['cajero'])){
                    $result['exception'] = 'Error al asignar el cajero';
                } elseif(!$encabezadoTransac->setTipoPago($S_POST['tipoPago'])){
                    $result['exception'] = 'Error al asignar el tipo de pago';
                } elseif(!$encabezadoTransac->setIdCodigoTransaccion($S_POST['codigoTransaccion'])){
                    $result['exception'] = 'Error al asignar el código de la transacción';
                } elseif(!$encabezadoTransac->setIdCliente($S_POST['cliente'])){
                    $result['exception'] = 'Error al asignar el cliente';
                } elseif(!$encabezadoTransac->setIdVendedor($S_POST['vendedor'])){
                    $result['exception'] = 'Error al asignar el vendedor';
                } elseif(!$encabezadoTransac->setIdProveedor($S_POST['proveedor'])){
                    $result['exception'] = 'Error al asignar el proveedor';
                } elseif(!$encabezadoTransac->setIdParametro($S_POST['parametro'])){
                    $result['exception'] = 'Error al asignar el parámetro';
                } elseif ($encabezadoTransac->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Encabezado de la transacción actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$encabezadoTransac->setId($_POST['idencatransaccion'])) {
                    $result['exception'] = 'Encabezado de la transacción incorrecto';
                } elseif (!$data = $encabezadoTransac->leerUnRegistro()) {
                    $result['exception'] = 'Encabezado de la transacción inexistente';
                } elseif ($encabezadoTransac->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Encabezado de la transacción eliminado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
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
