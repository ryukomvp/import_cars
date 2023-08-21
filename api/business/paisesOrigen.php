<?php
require_once('../entities/dto/paisesOrigen.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pais = new PaisesOrigen;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $pais->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $pais->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$pais->setpais($_POST['pais'])) {
                    $result['exception'] = 'País incorrecto';
                } elseif ($pais->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'País creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $pais->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'graficaCantidadProductosPais':
                $_POST = Validator::validateForm($_POST);
                if (!$pais->setId($_POST['idpais'])) {
                    $result['exception'] = 'Pais incorrecto';
                } elseif(!$data = $pais->leerUnRegistro()){
                    $result['exception'] = 'País inexistente';
                } elseif ($result['dataset'] = $pais->graficaCantidadProductosPais()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'País inexistente';
                }
                break;
            case 'leerUnRegistro':
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'País incorrecto';
                } elseif ($result['dataset'] = $pais->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'País inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $pais->leerUnRegistro()) {
                    $result['exception'] = 'País inexistente';
                } elseif (!$pais->setPais($_POST['pais'])) {
                    $result['exception'] = 'País incorrecto';
                } elseif ($pais->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pais modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$pais->setId($_POST['idpais'])) {
                    $result['exception'] = 'País incorrecta';
                } elseif (!$data = $pais->leerUnRegistro()) {
                    $result['exception'] = 'País inexistente';
                } elseif ($pais->eliminarRegistro()) {
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
