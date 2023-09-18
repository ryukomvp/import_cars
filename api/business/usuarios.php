<?php
// Se incluye la clase para la transferencia y acceso a datos.
//libreria phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../libraries/phpmailer651/src/PHPMailer.php');
require_once('../libraries/phpmailer651/src/SMTP.php');
require_once('../libraries/phpmailer651/src/Exception.php');
require_once('../entities/dto/usuarios.php');
require_once('../entities/dto/empleados.php');
// Verificación 
$special_charspattern = '/[^a-zA-Z\d]/';
// Variable para almacenar temporalmente los intentos de inicio de sesión.
$intentos = 0;

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
    $empleados = new empleados;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'checkSessionTime':
                if (Validator::validateSessionTime()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión activa';
                } else {
                    $result['exception'] = 'Su sesión ha caducado por inactividad';
                }
                break;
            case 'capturarUsuario':
                if (isset($_SESSION['nombreus'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombreus'];
                    // $result['usertype']  = $_SESSION['idtipousuario'];
                } else {
                    $result['exception'] = 'Nombre de usuario indefinido';
                }
                break;
            case 'cerrarSesion':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión cerrada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'leerPerfil':
                if ($result['dataset'] = $usuario->leerPerfil()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'cambiarClave':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['idusuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->verificarClave($_POST['clave-actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif (!preg_match($special_charspattern, $_POST['clave-nueva'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif ($_POST['clave-nueva'] != $_POST['clave-nueva']) {
                    $result['exception'] = 'La clave nueva debe ser diferente a la clave actual';
                } elseif ($_POST['clave-nueva'] != $_POST['clave-confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes, debe confirmar su nueva clave';
                } elseif (!$usuario->setClave($_POST['clave-nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->cambiarClave()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $usuario->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $usuario->buscarRegistros($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrecto';
                } elseif (!$usuario->setPin($_POST['pin'])) {
                    $result['exception'] = 'Pin incorrecto';
                } elseif (!$usuario->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo incorrecto';
                } elseif (!$usuario->setEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$usuario->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!preg_match($special_charspattern, $_POST['clave'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerRegistros':
                if ($result['dataset'] = $usuario->leerRegistros()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->leerUnRegistro()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrecto';
                } elseif (!$usuario->setPin($_POST['pin'])) {
                    $result['exception'] = 'Pin incorrecto';
                } elseif (!$usuario->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo incorrecto';
                } elseif (!$usuario->setEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$usuario->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$usuario->setVerificacion(isset($_POST['verificacion']) ? 1 : 0)) {
                    $result['exception'] = 'No se puede aplicar la verificacion';
                } elseif ($usuario->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if ($_POST['idusuario'] == $_SESSION['idusuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setId($_POST['idusuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->leerUnRegistro()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerTipos':
                if ($result['dataset'] = $usuario->leerTipos()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerEmpleados':
                if ($result['dataset'] = $usuario->leerEmpleados()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerEstados':
                if ($result['dataset'] = $usuario->leerEstados()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'leerUsuarios':
                if ($usuario->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe registrar un usuario para inicializar el sistema';
                }
                break;
            case 'leerEmpleados':
                if ($result['dataset'] = $empleados->leerEmpleados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'registrarPrimerEmpleado':
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
                } elseif (!$empleados->setEstado('Activo')) {
                    $result['exception'] = 'Estado del empleado incorrecto';
                } elseif (!$empleados->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero del empleado incorrecto';
                } elseif (!$empleados->setCargo('Jefe')) {
                    $result['exception'] = 'Cargo del empleado incorrecto';
                } elseif ($empleados->crearEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Primer empleado registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'registrarPrimerUsuario':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$usuario->setPin($_POST['pin'])) {
                    $result['exception'] = 'Pin incorrecto';
                } elseif (!$usuario->setTipo('1')) {
                    $result['exception'] = 'Tipo incorrecto';
                } elseif (!$usuario->setEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$usuario->setEstado('Activo')) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!preg_match($special_charspattern, $_POST['clave'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->crearRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Primer usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'iniciarSesion':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->verificarUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Nombre de usuario incorrecto';
                } elseif (!$usuario->verificarBloqueo($_POST['usuario'])) {
                    $result['exception'] = 'El usuario se encuentra bloqueado, comuniquese con un administrador.';
                } elseif (!$usuario->verificarClave($_POST['clave'])) {
                    if ($usuario->getIntentos() < 2) {
                        if ($usuario->actualizarIntentos()) {
                            $result['exception'] = 'Clave incorrecta';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        if ($usuario->bloquearUsuario()) {
                            $result['exception'] = 'Excedio el número de intentos para iniciar sesión, el usuario ha sido bloqueado.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    }
                    // } elseif ($usuario->leerDiasContra() >= 90) {
                    //     $_SESSION['idusuario'] = $usuario->getId();
                    //     $_SESSION['clave_caducada'] = $_POST['clave'];
                    //     $result['clave'] = true;
                    //     $result['exception'] = 'Su contraseña ha caducado';
                } else {
                    //generar codigo random
                    // $codigoveri = rand(10000, 99999);
                    //enviar codigo a la base de datos
                    // $usuario->ingresarCodigo($codigoveri);
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['tiempo_sesion'] = time();
                    $_SESSION['idusuario'] = $usuario->getId();
                    $_SESSION['nombreus'] = $usuario->getNombre();
                    // Inicio de sesión correcto, los intentos registrados en la base se resetean a 0.
                    $usuario->resetearIntentos();
                    $result['status'] = 1;
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
            case 'recuperacionClave':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->verificarUsuario($_POST['nombre'])) {
                    $result['exception'] = 'Nombre de usuario incorrecto';
                } elseif (!$usuario->verificarPin($_POST['pin'])) {
                    $result['exception'] = 'Pin de usuario incorrecto';
                } elseif (!$usuario->verificarPalabra($_POST['palabra'])) {
                    $result['exception'] = 'Palabra de usuario incorrecta';
                } elseif (!preg_match($special_charspattern, $_POST['clave'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->cambiarClave()) {
                    $usuario->resetearIntentos();
                    $result['status'] = 1;
                    $result['message'] = 'Cambiar clave correcto tilin :D';

                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
                break;
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
