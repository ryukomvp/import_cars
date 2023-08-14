<?php
require_once('../entities/dto/contactos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $contacto = new Contacto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $contacto->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $contacto->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$contacto->setNombreCajero($_POST['cajero'])) {
                    $result['exception'] = 'Nombre de cajero incorrecta';
                } else if (!$contacto->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Error al validar el estado';
                } else if (!$contacto->setFechaIngreso($_POST['fechaIngreso'])) {
                    $result['exception'] = 'Fecha incorrecta';
                } else if (!$contacto->setIdCaja($_POST['caja'])) {
                    $result['exception'] = 'Caja Incorrecta';
                } elseif ($contacto->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cajero creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $contacto->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$contacto->setId($_POST['id'])) {
                    $result['exception'] = 'Cajero incorrecta';
                } elseif ($result['dataset'] = $contacto->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cajero inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$contacto->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $contacto->leerUnRegistro()) {
                    $result['exception'] = 'Cajero inexistente';
                } elseif (!$contacto->setNombreCajero($_POST['cajero'])) {
                    $result['exception'] = 'Nombre de cajero incorrecta';
                } else if (!$contacto->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Error al validar el estado';
                } else if (!$contacto->setFechaIngreso($_POST['fechaIngreso'])) {
                    $result['exception'] = 'Fecha incorrecta';
                } else if (!$contacto->setIdCaja($_POST['caja'])) {
                    $result['exception'] = 'Caja Incorrecta';
                } elseif ($contacto->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cajero modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$contacto->setId($_POST['idcajero'])) {
                    $result['exception'] = 'Cajero incorrecta';
                } elseif (!$data = $contacto->leerUnRegistro()) {
                    $result['exception'] = 'Cajero inexistente';
                } elseif ($contacto->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cajero eliminado correctamente';
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
