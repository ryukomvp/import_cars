<?php
require_once('../entities/dto/CreditoFiscal.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $creditofiscal = new CreditoFiscal;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $creditofiscal->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $creditofiscal->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$creditofiscal->setNoRegistro($_POST['noregistro'])) {
                    $result['exception'] = 'Número de registro incorrecto';
                } else if (!$creditofiscal->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha incorrecto';
                } else if (!$creditofiscal->setDuiNit($_POST['duinit'])) {
                    $result['exception'] = 'Documento incorrecto';
                } else if (!$creditofiscal->setTipoDocumento($_POST['tipodoc'])) {
                    $result['exception'] = 'Tipo de documento incorrecto';
                } else if (!$creditofiscal->setTipoPersona($_POST['tipopersona'])) {
                    $result['exception'] = 'Tipo de persona incorrecta';
                } else if (!$creditofiscal->setRazonSocial($_POST['razonsocial'])) {
                    $result['exception'] = 'Razon social incorrecta';
                } else if (!$creditofiscal->setEmpresa($_POST['empresa'])) {
                    $result['exception'] = 'Empresa incorrecta';
                } else if (!$creditofiscal->setEmail($_POST['email'])) {
                    $result['exception'] = 'Correo Incorrecto';
                } else if (!$creditofiscal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } else if (!$creditofiscal->setIdPais($_POST['pais'])) {
                    $result['exception'] = 'Pais incorrecto';
                } else if (!$creditofiscal->setGiro($_POST['giro'])) {
                    $result['exception'] = 'Giro incorrecto';
                } else if (!$creditofiscal->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoria incorrecta';
                } else if (!$creditofiscal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif ($creditofiscal->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Credito fiscal creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $creditofiscal->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$creditofiscal->setId($_POST['id'])) {
                    $result['exception'] = 'No se pudo seleccionar el credito fiscal';
                } elseif ($result['dataset'] = $creditofiscal->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Credito Fiscal inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$creditofiscal->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $creditofiscal->leerUnRegistro()) {
                    $result['exception'] = 'No se pudo seleccionar el credito fiscal';
                } elseif (!$creditofiscal->setNoRegistro($_POST['noregistro'])) {
                    $result['exception'] = 'Número de registro incorrecto';
                } else if (!$creditofiscal->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha incorrecto';
                } else if (!$creditofiscal->setDuiNit($_POST['duinit'])) {
                    $result['exception'] = 'Documento incorrecto';
                } else if (!$creditofiscal->setTipoDocumento($_POST['tipodoc'])) {
                    $result['exception'] = 'Tipo de documento incorrecto';
                } else if (!$creditofiscal->setTipoPersona($_POST['tipopersona'])) {
                    $result['exception'] = 'Tipo de persona incorrecta';
                } else if (!$creditofiscal->setRazonSocial($_POST['razonsocial'])) {
                    $result['exception'] = 'Razon social incorrecta';
                } else if (!$creditofiscal->setEmpresa($_POST['empresa'])) {
                    $result['exception'] = 'Empresa incorrecta';
                } else if (!$creditofiscal->setEmail($_POST['email'])) {
                    $result['exception'] = 'Correo Incorrecto';
                } else if (!$creditofiscal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } else if (!$creditofiscal->setIdPais($_POST['pais'])) {
                    $result['exception'] = 'Pais incorrecto';
                } else if (!$creditofiscal->setGiro($_POST['giro'])) {
                    $result['exception'] = 'Giro incorrecto';
                } else if (!$creditofiscal->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoria incorrecta';
                } else if (!$creditofiscal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif ($creditofiscal->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Credito fiscal modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$creditofiscal->setId($_POST['idcreditofiscal'])) {
                    $result['exception'] = 'Credito fiscal incorrecto';
                } elseif (!$data = $creditofiscal->leerUnRegistro()) {
                    $result['exception'] = 'Credito fiscal inexistente';
                } elseif ($creditofiscal->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Credito fiscal eliminado correctamente';
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
