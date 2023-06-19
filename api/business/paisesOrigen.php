<?php
require_once('../entities/dto/paisesOrigen.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pais = new paisesOrigen;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idUsuario'])  OR !isset($_SESSION['idUsuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $pais->leerPaisesOrigen()) {
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
                        $result['dataset'] = $pais->leerPaisesOrigen();
                        $result['status'] = 1;
                } elseif ($result['dataset'] = $pais->buscarPaisOrigen($_POST['buscar'])) {
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
                if (!$pais->setpais($_POST['pais'])){
                    $result['exception'] = 'País incorrecto'; 
                } elseif ($pais->crearPaisOrigen()){
                    $result['status'] = 1;
                    $result['message'] = 'País creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;   
            case 'readOne':
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'País incorrecto';
                } elseif ($result['dataset'] = $pais->leerUnPaisOrigen()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'País inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
               if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $pais->leerUnPaisOrigen()) {
                    $result['exception'] = 'País inexistente';
                } elseif (!$pais->setPais($_POST['pais'])) {
                     $result['exception'] = 'País incorrecto';
                } elseif ($pais->actualizarPaisOrigen()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pais modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$pais->setId($_POST['idpais'])) {
                    $result['exception'] = 'País incorrecta';
                } elseif (!$data = $pais->leerUnPaisOrigen()) {
                    $result['exception'] = 'País inexistente';
                } elseif ($pais->eliminarPaisOrigen()) {
                    $result['status'] = 1;
                    $result['message'] = 'País eliminado correctamente';
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