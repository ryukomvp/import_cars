<?php
require_once('../entities/dto/entradas.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $entradas = new Entradas;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idUsuario']) OR !isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $entradas->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $entradas->buscarRegistros($_POST['buscar'])) {
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
                if (!$entradas->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion incorrecto';
                } elseif (!$entradas->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$entradas->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif (!$entradas->setPrecio($_POST['precio'])){
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['empleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$entradas->setEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'codigo incorrecta';
                } elseif ($entradas->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Registro creado';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $entradas->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$entradas->setId($_POST['id'])) {
                    $result['exception'] = 'entrada incorrecto';
                } elseif ($result['dataset'] = $entradas->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Entrada inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$entradas->setId($_POST['id'])) {
                    $result['exception'] = 'Entrada incorrecto';
                } elseif (!$data = $entradas->leerUnRegistro()) {
                    $result['exception'] = 'Entrada inexistente';
                } elseif (!$entradas->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$entradas->setProducto($_POST['producto'])){
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!isset($_POST['empleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif ($entradas->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                    if (!$entradas->setId($_POST['identrada'])) {
                        $result['exception'] = 'Id incorrecto';
                    } elseif (!$data = $entradas->leerUnRegistro()) {
                        $result['exception'] = 'Marca inexistente';
                    } elseif ($entradas->eliminarRegistro()) {
                        $result['status'] = 1;
                        $result['message'] = 'Entrada eliminada correctamente';
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
