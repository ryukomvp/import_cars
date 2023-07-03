<?php
// Se incluye la clase para la transferencia y acceso a datos.
require_once('../entities/dto/modelos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $modelo = new Modelo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['search'] == '') {
                    $result['dataset'] = $modelo->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $modelo->buscarRegistros($_POST['search'])) {
                       $result['status'] = 1;
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$modelo->setModelo($_POST['modelo'])){
                    $result['exception'] = 'Nombre incorrecto'; 
                } elseif (!$modelo->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecto';
                } elseif ($modelo->crearRegistro()){
                    $result['status'] = 1;
                    $result['message'] = 'Modelo creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $modelo->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$modelo->setId($_POST['idmodelo'])) {
                        $result['exception'] = 'Modelo incorrecta';
                } elseif ($result['dataset'] = $modelo->leerUnRegistro()) {
                       $result['status'] = 1;
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                       $result['exception'] = 'Modelo inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
               if (!$modelo->setId($_POST['id'])) {
                    $result['exception'] = 'Modelo incorrecta';
                } elseif (!$data = $modelo->leerModelo()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$modelo->setModelo($_POST['modelo'])) {
                     $result['exception'] = 'Nombre incorrecto';
                } elseif (!$modelo->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif ($modelo->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$modelo->setId($_POST['idmodelo'])) {
                    $result['exception'] = 'Id incorrecto';
                } elseif (!$data = $modelo->leerModelo()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif ($modelo->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modelo eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'cargarMarcas':
                if ($result['dataset'] = $modelo->cargarMarcas()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
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