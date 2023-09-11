<?php
require_once('../entities/dto/parametros.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $parametro = new Parametro;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $parametro->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $parametro->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$parametro->setNombreEmp($_POST['nombreEmp'])) {
                    $result['exception'] = 'Nombre de empresa incorrecto';
                } else if (!$parametro->setDireccionEmp($_POST['direccionEmp'])) {
                    $result['exception'] = 'Dirección de empresa incorrecto';
                } else if (!$parametro->setPorcentaje($_POST['porcentaje'])) {
                    $result['exception'] = 'Porcentaje incorrecto';
                } else if (!$parametro->setRegistro($_POST['registro'])) {
                    $result['exception'] = '# registro incorrecta';
                } else if (!$parametro->setGiroEmpresa($_POST['giro'])) {
                    $result['exception'] = 'Giro de la empresa incorrecta';
                } else if (!$parametro->setNit($_POST['nit'])) {
                    $result['exception'] = 'NIT Incorrecta';
                } else if (!$parametro->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI Incorrecta';
                } else if (!$parametro->setIdContacto($_POST['contacto'])) {
                    $result['exception'] = 'Error al seleccionar el contacto';
                } elseif ($parametro->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parametro creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $parametro->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$parametro->setId($_POST['id'])) {
                    $result['exception'] = 'No se pudo seleccionar el parametro';
                } elseif ($result['dataset'] = $parametro->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Contacto inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$parametro->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $parametro->leerUnRegistro()) {
                    $result['exception'] = 'No se pudo seleccionar el contacto';
                } elseif (!$parametro->setNombreEmp($_POST['nombreEmp'])) {
                    $result['exception'] = 'Nombre de empresa incorrecto';
                } else if (!$parametro->setDireccionEmp($_POST['direccionEmp'])) {
                    $result['exception'] = 'Dirección de empresa incorrecto';
                } else if (!$parametro->setPorcentaje($_POST['porcentaje'])) {
                    $result['exception'] = 'Porcentaje incorrecto';
                } else if (!$parametro->setRegistro($_POST['registro'])) {
                    $result['exception'] = '# registro incorrecta';
                } else if (!$parametro->setGiroEmpresa($_POST['giro'])) {
                    $result['exception'] = 'Giro de la empresa incorrecta';
                } else if (!$parametro->setNit($_POST['nit'])) {
                    $result['exception'] = 'NIT Incorrecta';
                } else if (!$parametro->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI Incorrecta';
                } else if (!$parametro->setIdContacto($_POST['contacto'])) {
                    $result['exception'] = 'Error al seleccionar el contacto';
                } elseif ($parametro->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parametro modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$parametro->setId($_POST['idparametro'])) {
                    $result['exception'] = 'Parametro incorrecto';
                } elseif (!$data = $parametro->leerUnRegistro()) {
                    $result['exception'] = 'Parametro inexistente';
                } elseif ($parametro->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parametro eliminado correctamente';
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
