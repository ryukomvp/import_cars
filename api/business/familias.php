<?php
require_once('../entities/dto/familias.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $familia = new Familias;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $familia->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $familia->buscarRegistros($_POST['search'])) {
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
                if(!$familia->setFamilia($_POST['familia'])) {
                    $result['exception'] = 'Familia incorrecta';
                } elseif($familia->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Familia creada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $familia->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$familia->setId($_POST['idfamilia'])) {
                    $result['exception'] = 'Registro de familia incorrecto';
                } elseif ($result['dataset'] = $familia->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Registro inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$familia->setId($_POST['id'])) {
                    $result['exception'] = 'Familia incorrecta';
                } elseif (!$familia->leerUnRegistro()) {
                    $result['exception'] = 'Familia inexistente';
                } elseif (!$familia->setFamilia($_POST['familia'])) {
                    $result['exception'] = 'Familia incorrecta';
                } elseif ($familia->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Familia actualizada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$familia->setId($_POST['idfamilia'])) {
                    $result['exception'] = 'Familia incorrecta';
                } elseif (!$data = $familia->leerUnRegistro()) {
                    $result['exception'] = 'Sucursal inexistente';
                } elseif ($familia->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Familia eliminada exitosamente';
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