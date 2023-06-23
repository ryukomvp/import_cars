<?php
require_once('../entities/dto/codigosComunes.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $codigo = new codigoComun;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'leerCodigosComunes':
                if ($result['dataset'] = $codigo->leerCodigosComunes()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'buscarCodigoComun':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['buscar'] == '') {
                        $result['dataset'] = $codigo->leerCodigosComunes();
                        $result['status'] = 1;
                } elseif ($result['dataset'] = $codigo->buscarCodigoComun($_POST['buscar'])) {
                       $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'crearCodigoComun':
                $_POST = Validator::validateForm($_POST);
                if (!$codigo->setNomenclatura($_POST['nomenclatura'])) {
                    $result['exception'] = 'Nomenclatura incorrecta'; 
                } elseif (!$codigo->setCodigo($_POST['codigo'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif ($codigo->crearCodigoComun()){
                    $result['status'] = 1;
                    $result['message'] = 'Código común creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;   
            case 'leerUnCodigoComun':
                if (!$codigo->setId($_POST['id'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif ($result['dataset'] = $codigo->leerUnCodigoComun()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Código común inexistente';
                }
                break;
            case 'actualizarCodigoComun':
                $_POST = Validator::validateForm($_POST);
               if (!$codigo->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $codigo->leerUnCodigoComun()) {
                    $result['exception'] = 'Moneda inexistente';
                } elseif (!$codigo->setNomenclatura($_POST['nomenclatura'])) {
                     $result['exception'] = 'Moneda incorrecto';
                } elseif (!$codigo->setCodigo($_POST['codigo'])) {
                    $result['exception'] = 'Moneda incorrecto';
                } elseif ($codigo->actualizarCodigoComun()) {
                    $result['status'] = 1;
                    $result['message'] = 'Moneda modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarCodigoComun':
                if (!$codigo->setId($_POST['idcodigocomun'])) {
                    $result['exception'] = 'Código incorrecto';
                } elseif (!$data = $codigo->leerUnCodigoComun()) {
                    $result['exception'] = 'Código inexistente';
                } elseif ($codigo->eliminarCodigoComun()) {
                    $result['status'] = 1;
                    $result['message'] = 'Código eliminado correctamente';
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