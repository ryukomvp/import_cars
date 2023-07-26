<?php
require_once('../entities/dto/monedas.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $moneda = new Moneda;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['buscar'] == '') {
                        $result['dataset'] = $moneda->leerRegistros();
                        $result['status'] = 1;
                } elseif ($result['dataset'] = $moneda->buscarRegistros($_POST['buscar'])) {
                       $result['status'] = 1;
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$moneda->setMoneda($_POST['moneda'])){
                    $result['exception'] = 'Moneda incorrecto'; 
                } elseif ($moneda->crearRegistro()){
                    $result['status'] = 1;
                    $result['message'] = 'Moneda creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;  
            case 'leerRegistros':
                if ($result['dataset'] = $moneda->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break; 
            case 'leerUnRegistro':
                if (!$moneda->setId($_POST['id'])) {
                    $result['exception'] = 'Moneda incorrecto';
                } elseif ($result['dataset'] = $moneda->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Moneda inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
               if (!$moneda->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $moneda->leerUnRegistro()) {
                    $result['exception'] = 'Moneda inexistente';
                } elseif (!$moneda->setMoneda($_POST['moneda'])) {
                     $result['exception'] = 'Moneda incorrecto';
                } elseif ($moneda->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Moneda modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$moneda->setId($_POST['idmoneda'])) {
                    $result['exception'] = 'Moneda incorrecta';
                } elseif (!$data = $moneda->leerUnRegistro()) {
                    $result['exception'] = 'Moneda inexistente';
                } elseif ($moneda->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Moneda eliminada correctamente';
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