<?php
require_once('../entities/dto/cajas.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $caja = new Caja;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $caja->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $caja->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$caja->setNombreCaja($_POST['caja'])) {
                    $result['exception'] = 'Nombre de caja incorrecta';
                } else if (!$caja->setNombreEquipo($_POST['equipo'])) {
                    $result['exception'] = 'Nombre del equipo incorrecto';
                } else if (!$caja->setSerieEquipo($_POST['serie'])) {
                    $result['exception'] = 'Serie incorrecta';
                } else if (!$caja->setModeloEquipo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo del equipo incorrecto';
                } else if (!$caja->setIdSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } else if (!$caja->setIdUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($caja->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Caja creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $caja->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$caja->setId($_POST['id'])) {
                    $result['exception'] = 'No se pudo seleccionar la caja';
                } elseif ($result['dataset'] = $caja->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Caja inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$caja->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $caja->leerUnRegistro()) {
                    $result['exception'] = 'No se pudo seleccionar la caja';
                } elseif (!$caja->setNombreCaja($_POST['caja'])) {
                    $result['exception'] = 'Nombre de caja incorrecta';
                } else if (!$caja->setNombreEquipo($_POST['equipo'])) {
                    $result['exception'] = 'Nombre del equipo incorrecto';
                } else if (!$caja->setSerieEquipo($_POST['serie'])) {
                    $result['exception'] = 'Serie incorrecta';
                } else if (!$caja->setModeloEquipo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo del equipo incorrecto';
                } else if (!$caja->setIdSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal incorrecta';
                } else if (!$caja->setIdUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($caja->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Caja modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$caja->setId($_POST['idcaja'])) {
                    $result['exception'] = 'Caja incorrecta';
                } elseif (!$data = $caja->leerUnRegistro()) {
                    $result['exception'] = 'Caja inexistente';
                } elseif ($caja->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Caja eliminada correctamente';
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
