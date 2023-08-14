<?php
// Se incluye la clase para la transferencia y acceso a datos.
require_once('../entities/dto/vendedores.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $vendedor = new Vendedor;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $vendedor->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $vendedor->buscarRegistros($_POST['search'])) {
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
                if (!$vendedor->setIdUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$vendedor->setIdCaja($_POST['caja'])) {
                    $result['exception'] = 'Caja incorrecta';
                } elseif ($vendedor->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vendedor creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $vendedor->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$vendedor->setId($_POST['id'])) {
                    $result['exception'] = 'No se pudo seleccionar el vendedor';
                } elseif ($result['dataset'] = $vendedor->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Registro inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$vendedor->setId($_POST['id'])) {
                    $result['exception'] = 'No se pudo seleccionar el vendedor';
                } elseif (!$data = $vendedor->leerUnRegistro()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$vendedor->setIdUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$vendedor->setIdCaja($_POST['caja'])) {
                    $result['exception'] = 'Caja incorrecta';
                } elseif ($vendedor->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vendedor actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$vendedor->setId($_POST['idvendedor'])) {
                    $result['exception'] = 'No se pudo seleccionar el vendedor';
                } elseif (!$data = $vendedor->leerUnRegistro()) {
                    $result['exception'] = 'Vendedor inexistente';
                } elseif ($vendedor->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vendedor eliminado exitosamente';
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
