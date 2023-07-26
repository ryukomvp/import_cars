<?php
require_once('../entities/dto/tiposProductos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipo = new TiposProductos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $tipo->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $tipo->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$tipo->setTipoProducto($_POST['tipoProducto'])){
                    $result['exception'] = 'Tipo de producto incorrecto'; 
                } elseif ($tipo->crearRegistro()){
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $tipo->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif ($result['dataset'] = $tipo->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Tipo de producto inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
               if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $tipo->leerUnRegistro()) {
                    $result['exception'] = 'Tipo de producto inexistente';
                } elseif (!$tipo->setTipoProducto($_POST['tipoProducto'])) {
                     $result['exception'] = 'Tipo de producto incorrecto';
                } elseif ($tipo->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$tipo->setId($_POST['idtipoproducto'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif (!$data = $tipo->leerUnRegistro()) {
                    $result['exception'] = 'Tipo de producto inexistente';
                } elseif ($tipo->eliminarRegistro()) {
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