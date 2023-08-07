<?php
require_once('../entities/dto/sucursales.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $sucursal = new sucursal;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario']) or !isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $sucursal->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $sucursal->readAll();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $sucursal->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$sucursal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$sucursal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Numero de telefono incorrecto';
                } elseif (!$sucursal->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$sucursal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif ($sucursal->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Registro creado';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$sucursal->setId($_POST['idsucursal'])) {
                    $result['exception'] = 'sucursal incorrecta';
                } elseif ($result['dataset'] = $sucursal->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Sucursal inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$sucursal->setId($_POST['id'])) {
                    $result['exception'] = 'sucursal incorrecta';
                } elseif (!$sucursal->readOne()) {
                    $result['exception'] = 'Sucursal inexistente';
                } elseif (!$sucursal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$sucursal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                } elseif (!$sucursal->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$sucursal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif ($sucursal->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sucursal modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$sucursal->setId($_POST['idsucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } elseif (!$data = $sucursal->readOne()) {
                    $result['exception'] = 'Sucursal inexistente';
                } elseif ($sucursal->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sucursal eliminada correctamente';
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
