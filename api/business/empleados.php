<?php
require_once('../entities/dto/empleados.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $empleados = new empleados;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])  or !isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'leerEmpleados':
                if ($result['dataset'] = $empleados->leerEmpleados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'buscarEmpleado':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $empleados->leerEmpleados();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $empleados->buscarEmpleado($_POST['buscar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearEmpleado':
                $_POST = Validator::validateForm($_POST);
                if (!$empleados->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$empleados->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfonon incorrecto';
                } elseif (!$empleados->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$empleados->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento incorrecta';
                } elseif (!$empleados->setDocumento($_POST['documento'])) {
                    $result['exception'] = 'Documento incorrecto';
                } elseif (!$empleados->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado del empleado incorrecto';
                } elseif (!$empleados->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero del empleado incorrecto';
                } elseif (!$empleados->setCargo($_POST['cargo'])) {
                    $result['exception'] = 'Cargo del empleado incorrecto';
                } elseif ($empleados->crearEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerUnEmpleado':
                if (!$empleados->setIdempleado($_POST['id'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif ($result['dataset'] = $empleados->leerUnEmpleado()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Empleado inexistente';
                }
                break;
            case 'actualizarEmpleado':
                $_POST = Validator::validateForm($_POST);
                if (!$empleados->setIdempleado($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $empleados->leerUnEmpleado()) {
                    $result['exception'] = 'Empleado inexistente';
                } elseif (!$empleados->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$empleados->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfonon incorrecto';
                } elseif (!$empleados->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$empleados->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento incorrecta';
                } elseif (!$empleados->setDocumento($_POST['documento'])) {
                    $result['exception'] = 'Documento incorrecto';
                } elseif (!$empleados->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado del empleado incorrecto';
                } elseif (!$empleados->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero del empleado incorrecto';
                } elseif (!$empleados->setCargo($_POST['cargo'])) {
                    $result['exception'] = 'Cargo del empleado incorrecto';
                } elseif ($empleados->actualizarEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'eliminarEmpleado':
                if (!$empleados->setIdempleado($_POST['idempleado'])) {
                    $result['exception'] = 'Empleado incorrecta';
                } elseif (!$data = $empleados->leerUnEmpleado()) {
                    $result['exception'] = 'Empleado inexistente';
                } elseif ($empleados->eliminarEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerEstadosEmpleados':
                if ($result['dataset'] = $empleados->leerEstadosEmpleados()) {
                    $result['status'] = 1;
                    //$result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerGeneros':
                if ($result['dataset'] = $empleados->leerGeneros()) {
                    $result['status'] = 1;
                    //$result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerCargos':
                if ($result['dataset'] = $empleados->leerCargos()) {
                    $result['status'] = 1;
                    //$result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'empleadosCargos':
                // Condicion para retornar a la consulta
                if ($result['dataset'] = $empleados->empleadoCargo()) {
                    $result['status'] = 1;
                    // Si no retorna la exception
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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
