<?php
require_once('../entities/dto/codigosTransacciones.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $codigoTransac = new CodigoTransacciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $codigoTransac->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $codigoTransac->buscarRegistros($_POST['buscar'])) {
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
                if (!$codigoTransac->setCodigo($_POST['codigo'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif(!$codigoTransac->setNombreCodigo($_POST['nombreCodigo'])){
                    $result['exception'] = 'Nombre incorrecto';
                } elseif ($codigoTransac->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código de transacción creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $codigoTransac->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$codigoTransac->setId($_POST['id'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif ($result['dataset'] = $codigoTransac->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Código común inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$codigoTransac->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $codigoTransac->leerUnRegistro()) {
                    $result['exception'] = 'Código de transacción inexistente';
                } elseif (!$codigoTransac->setCodigo($_POST['codigo'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif(!$codigoTransac->setNombreCodigo($_POST['nombreCodigo'])){
                    $result['exception'] = 'Nombre incorrecto';
                } elseif ($codigoTransac->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código común actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$codigoTransac->setId($_POST['idcodigotransaccion'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif (!$data = $codigoTransac->leerUnRegistro()) {
                    $result['exception'] = 'Código inexistente';
                } elseif ($codigoTransac->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código de transacción eliminado exitosamente';
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
