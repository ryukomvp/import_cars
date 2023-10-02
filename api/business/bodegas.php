<?php
require_once('../entities/dto/bodegas.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $bodega = new Bodegas;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario']) AND $_SESSION['permissions']['bodegas']) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $bodega->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $bodega->buscarRegistros($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // Caso para crear un registro en la tabla
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$bodega->setNumeroBodega($_POST['numerobodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$bodega->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$bodega->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } elseif ($bodega->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Bodega creada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer todos los registros en la tabla
            case 'leerRegistros':
                if ($result['dataset'] = $bodega->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
                // Caso para leer un registro seleccionado por el administrador
            case 'leerUnRegistro':
                if (!$bodega->setId($_POST['id'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif ($result['dataset'] = $bodega->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Registro inexistente';
                }
                break;
                // Caso para actualizar un registro seleccionado por el administrador
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$bodega->setId($_POST['id'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$bodega->leerUnRegistro()) {
                    $result['exception'] = 'Bodega inexistente';
                } elseif (!$bodega->setNumeroBodega($_POST['numerobodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$bodega->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$bodega->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } elseif ($bodega->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Bodega actualizada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para eliminar un registro seleccionado por el administrador
            case 'eliminarRegistro':
                if (!$bodega->setId($_POST['idbodega'])) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$data = $bodega->leerUnRegistro()) {
                    $result['exception'] = 'Bodega inexistente';
                } elseif ($bodega->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Bodega eliminada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para cargar los registros de una tabla externa (sucursales)
            case 'cargarSucursal':
                if ($result['dataset'] = $bodega->cargarSucursal()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
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
