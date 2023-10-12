<?php
require_once('../entities/dto/clientes.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new CLiente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $cliente->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $cliente->buscarRegistros($_POST['buscar'])) {
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
                if (!$cliente->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del cliente incorrecto';
                } elseif (!$cliente->setGiro($_POST['giro'])) {
                    $result['exception'] = 'Giro incorrecto';
                } elseif (!$cliente->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$cliente->setContacto($_POST['contacto'])) {
                    $result['exception'] = 'Contacto adicional incorrecto';
                } elseif (!$cliente->setDescuento($_POST['descuento'])) {
                    $result['exception'] = 'Descuento incorrecto';
                } elseif (!$cliente->setExoneracion($_POST['exoneracion'])) {
                    $result['exception'] = 'Exoneración incorrecta';
                } elseif (!$cliente->setFechaIni($_POST['fechaIni'])) {
                    $result['exception'] = 'Fecha seleccionada incorrecta';
                } elseif (!$cliente->setTipoCliente($_POST['tipoCliente'])) {
                    $result['exception'] = 'Error al seleccionar el tipo de cliente';
                } elseif (!$cliente->setIdPlazo($_POST['plazo'])) {
                    $result['exception'] = 'Error al seleccionar el plazo';
                } elseif ($cliente->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente creado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $cliente->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay registros';
                }
                break;
            case 'leerUnRegistro':
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $cliente->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $cliente->leerUnRegistro()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif (!$cliente->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del cliente incorrecto';
                } elseif (!$cliente->setGiro($_POST['giro'])) {
                    $result['exception'] = 'Giro incorrecto';
                } elseif (!$cliente->setDui($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$cliente->setContacto($_POST['contacto'])) {
                    $result['exception'] = 'Contacto adicional incorrecto';
                } elseif (!$cliente->setDescuento($_POST['descuento'])) {
                    $result['exception'] = 'Descuento incorrecto';
                } elseif (!$cliente->setExoneracion($_POST['exoneracion'])) {
                    $result['exception'] = 'Exoneración incorrecta';
                } elseif (!$cliente->setFechaIni($_POST['fechaIni'])) {
                    $result['exception'] = 'Fecha seleccionada incorrecta';
                } elseif (!$cliente->setTipoCliente($_POST['tipoCliente'])) {
                    $result['exception'] = 'Error al seleccionar el tipo de cliente';
                } elseif (!$cliente->setIdPlazo($_POST['plazo'])) {
                    $result['exception'] = 'Error al seleccionar el plazo';
                } elseif ($cliente->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$cliente->setId($_POST['idcliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $cliente->leerUnRegistro()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif ($cliente->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente eliminado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerTiposClientes':
                if ($result['dataset'] = $cliente->leerTiposClientes()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
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
