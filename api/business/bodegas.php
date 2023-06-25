<?php
require_once('../entities/dto/bodegas.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $bodega = new bodegas;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario']) OR !isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $bodega->readAll()) {
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
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $bodega->searchRows($_POST['search'])) {
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
                if(!$bodega->setNumerobodega($_POST['numerobodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif(!$bodega->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif(!$bodega->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } elseif($bodega->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Registro creado';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'cargarSucursal':
                    if($result['dataset'] = $bodega->cargarSucursal()){
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']). ' registros';
                    } elseif(Database::getException()){
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;  
            case 'readOne':
                if (!$bodega->setId($_POST['idbodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif ($result['dataset'] = $bodega->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Bodega inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$bodega->setId($_POST['id'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$bodega->readOne()) {
                    $result['exception'] = 'Bodega inexistente';
                } elseif (!$bodega->setNumerobodega($_POST['numerobodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$bodega->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif (!$bodega->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } elseif ($bodega->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Bodega modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$bodega->setId($_POST['idbodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$data = $bodega->readOne()) {
                    $result['exception'] = 'Bodega inexistente';
                } elseif ($bodega->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Bodega eliminada correctamente';
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