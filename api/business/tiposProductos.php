<?php
require_once('../entities/dto/tipoProducto.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipo = new tipoProducto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'leerTiposProductos':
                if ($result['dataset'] = $tipo->leerTiposProductos()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'buscarTipoProducto':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['buscar'] == '') {
                        $result['dataset'] = $tipo->leerTiposProductos();
                        $result['status'] = 1;
                } elseif ($result['dataset'] = $tipo->buscarTiposProducto($_POST['buscar'])) {
                       $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'crearTipoProducto':
                $_POST = Validator::validateForm($_POST);
                if (!$tipo->setTipoProducto($_POST['tipoProducto'])){
                    $result['exception'] = 'Tipo de producto incorrecto'; 
                } elseif ($tipo->crearPaisOrigen()){
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;   
            case 'leerTipoProducto':
                if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif ($result['dataset'] = $tipo->leerTipoProducto()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Tipo de producto inexistente';
                }
                break;
            case 'actualizarTipoProducto':
                $_POST = Validator::validateForm($_POST);
               if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $tipo->leerTipoProducto()) {
                    $result['exception'] = 'Tipo de producto inexistente';
                } elseif (!$tipo->setTipoProducto($_POST['pais'])) {
                     $result['exception'] = 'Tipo de producto incorrecto';
                } elseif ($tipo->actualizarTipoProducto()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarTipoProducto':
                if (!$tipo->setId($_POST['idtipoproducto'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif (!$data = $tipo->leerTipoProducto()) {
                    $result['exception'] = 'Tipo de producto inexistente';
                } elseif ($tipo->eliminarTipoProducto()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto eliminado correctamente';
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