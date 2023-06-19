<?php
require_once('../entities/dto/proveedores.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $proveedores = new proveedores;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idUsuario'])  OR !isset($_SESSION['idUsuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $proveedores->leerProveedores()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['buscar'] == '') {
                        $result['dataset'] = $proveedores->leerProveedores();
                        $result['status'] = 1;
                } elseif ($result['dataset'] = $proveedores->buscarProveedor($_POST['buscar'])) {
                       $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$proveedores->setNombre($_POST['nombre'])){
                    $result['exception'] = 'Nombre incorrecto'; 
                } elseif (!$proveedores->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfonon incorrecto';
                } elseif (!$proveedores->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$proveedores->setFechaCompra($_POST['fechaProv'])) {
                    $result['exception'] = 'Fecha de compra incorrecta';
                } elseif (!$proveedores->setSaldoInicial($_POST['saldoInicial'])) {
                    $result['exception'] = 'Saldo inicial incorrecto';
                } elseif (!$proveedores->setSaldoActual($_POST['saldoActual'])) {
                    $result['exception'] = 'Saldo actual incorrecto';
                } elseif (!$proveedores->setCodigoProv($_POST['codigoProv'])) {
                    $result['exception'] = 'Codigo del proveedor incorrecto';
                } elseif (!$proveedores->setCodigoMaestroProv($_POST['codigoMaestroProv'])) {
                    $result['exception'] = 'Codigo maestro del proveedor incorrecto';
                } elseif (!$proveedores->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI del proveedor incorrecto';
                } elseif (!$proveedores->setIdMoneda($_POST['moneda'])) {
                    $result['exception'] = 'Tipo de moneda inválida';
                } elseif (!$proveedores->setNumeroRegistroProv($_POST['numeroRegistroProv'])) {
                    $result['exception'] = 'Numero de registro del proveedor incorrecto';
                } elseif ($proveedores->crearProveedor()){
                    $result['status'] = 1;
                    $result['message'] = 'Proveedor creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;   
            case 'readOne':
                if (!$proveedores->setId($_POST['id'])) {
                    $result['exception'] = 'Proveedor incorrecto';
                } elseif ($result['dataset'] = $proveedores->leerunProveedor()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Proveedor inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
               if (!$proveedores->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $proveedores->leerunProveedor()) {
                    $result['exception'] = 'Proveedor inexistente';
                } elseif (!$proveedores->setNombre($_POST['nombre'])) {
                     $result['exception'] = 'Proveedor incorrecto';
                } elseif (!$proveedores->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfonon incorrecto';
                } elseif (!$proveedores->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$proveedores->setFechaCompra($_POST['fechaProv'])) {
                    $result['exception'] = 'Fecha de compra incorrecta';
                } elseif (!$proveedores->setSaldoInicial($_POST['saldoInicial'])) {
                    $result['exception'] = 'Saldo inicial incorrecto';
                } elseif (!$proveedores->setSaldoActual($_POST['saldoActual'])) {
                    $result['exception'] = 'Saldo actual incorrecto';
                } elseif (!$proveedores->setCodigoProv($_POST['codigoProv'])) {
                    $result['exception'] = 'Codigo del proveedor incorrecto';
                } elseif (!$proveedores->setCodigoMaestroProv($_POST['codigoMaestroProv'])) {
                    $result['exception'] = 'Codigo maestro del proveedor incorrecto';
                } elseif (!$proveedores->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI del proveedor incorrecto';
                } elseif (!$proveedores->setIdMoneda($_POST['moneda'])) {
                    $result['exception'] = 'Tipo de moneda inválida';
                } elseif (!$proveedores->setNumeroRegistroProv($_POST['numeroRegistroProv'])) {
                    $result['exception'] = 'Numero de registro del proveedor incorrecto';
                } elseif ($proveedores->actualizarProveedor()) {
                    $result['status'] = 1;
                    $result['message'] = 'Proveedormodificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$proveedores->setId($_POST['idproveedor'])) {
                    $result['exception'] = 'Proveedor incorrecta';
                } elseif (!$data = $proveedores->leerunProveedor()) {
                    $result['exception'] = 'Proveedor inexistente';
                } elseif ($proveedores->eliminarProveedor()) {
                    $result['status'] = 1;
                    $result['message'] = 'Proveedor eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                    $result['exception'] = 'Acción no disponible dentro de la sesión';
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