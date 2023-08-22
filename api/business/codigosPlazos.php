<?php
require_once('../entities/dto/codigosPlazos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $plazo = new CodigoPlazo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $plazo->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $plazo->buscarRegistros($_POST['buscar'])) {
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
                if (!$plazo->setPlazo($_POST['plazo'])) {
                    $result['exception'] = 'Plazo incorrecto';
                } elseif (!$plazo->setDias($_POST['dias'])) {
                    $result['exception'] = 'Dia incorrecto';
                } elseif ($plazo->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código de plazo creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $plazo->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$plazo->setId($_POST['id'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif ($result['dataset'] = $plazo->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Plazo inexistente';
                }
                break;
            case 'graficaCantidadPlazos':
                $_POST = Validator::validateForm($_POST);
                if(!$plazo->setId($_POST['idcodigoplazo'])) {
                    $result['exception'] = 'Codigo incorrecto';
                } elseif(!$data = $plazo->leerUnRegistro()) {
                    $result['exception'] = 'Codigo inexistente';
                } elseif($result['dataset'] = $plazo->graficaCantidadPlazos()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'Codigo sin plazos';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$plazo->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $plazo->leerUnRegistro()) {
                    $result['exception'] = 'Código de plazo inexistente';
                } elseif (!$plazo->setPlazo($_POST['plazo'])) {
                    $result['exception'] = 'Plazo incorrecto';
                } elseif (!$plazo->setDias($_POST['dias'])) {
                    $result['exception'] = 'Dia incorrecto';
                } elseif ($plazo->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código de plazo actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$plazo->setId($_POST['idcodigoplazo'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif (!$data = $plazo->leerUnRegistro()) {
                    $result['exception'] = 'Código inexistente';
                } elseif ($plazo->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código plazo eliminado exitosamente';
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
