<?php
// Se incluye la clase para la transferencia y acceso a datos.
require_once('../entities/dto/usuarios.php');
// Verificación 
$special_charspattern = '/[^a-zA-Z\d]/';

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
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
                    $result['exception'] = 'Su sesión ha caducado';
                }
                break;
            case 'capturarUsuario':
                if (isset($_SESSION['nombreus'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombreus'];
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
                // case 'readProfile':
                //     if ($result['dataset'] = $usuario->readProfile()) {
                //         $result['status'] = 1;
                //     } elseif (Database::getException()) {
                //         $result['exception'] = Database::getException();
                //     } else {
                //         $result['exception'] = 'Usuario inexistente';
                //     }
                //     break;
                // case 'editProfile':
                //     $_POST = Validator::validateForm($_POST);
                //     if (!$usuario->setNombres($_POST['nombres'])) {
                //         $result['exception'] = 'Nombres incorrectos';
                //     } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                //         $result['exception'] = 'Apellidos incorrectos';
                //     } elseif (!$usuario->setCorreo($_POST['correo'])) {
                //         $result['exception'] = 'Correo incorrecto';
                //     } elseif (!$usuario->setAlias($_POST['alias'])) {
                //         $result['exception'] = 'Alias incorrecto';
                //     } elseif ($usuario->editProfile()) {
                //         $result['status'] = 1;
                //         $_SESSION['alias_usuario'] = $usuario->getAlias();
                //         $result['message'] = 'Perfil modificado correctamente';
                //     } else {
                //         $result['exception'] = Database::getException();
                //     }
                //     break;
            case 'cambiarClave':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['idusuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->verificarClave($_POST['clave-actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif (!preg_match($special_charspattern, $_POST['clave-nueva'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif ($_POST['clave-nueva'] != $_POST['confirmar-clave-nueva']) {
                    $result['exception'] = 'Claves nuevas diferentes, debe confirmar su nueva clave';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
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
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                // case 'regitrarUsuario':
                //     $_POST = Validator::validateForm($_POST);
                //     if (!$usuario->setNombres($_POST['nombres'])) {
                //         $result['exception'] = 'Nombres incorrectos';
                //     } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                //         $result['exception'] = 'Apellidos incorrectos';
                //     } elseif (!$usuario->setCorreo($_POST['correo'])) {
                //         $result['exception'] = 'Correo incorrecto';
                //     } elseif (!$usuario->setAlias($_POST['usuario'])) {
                //         $result['exception'] = 'Alias incorrecto';
                //     } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                //         $result['exception'] = 'Claves diferentes';
                //     } elseif (!$usuario->setClave($_POST['codigo'])) {
                //         $result['exception'] = Validator::getPasswordError();
                //     } elseif ($usuario->createRow()) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Usuario registrado correctamente';
                //     } else {
                //         $result['exception'] = Database::getException();
                //     }
                //     break;
            case 'iniciarSesion':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->verificarUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->verificarClave($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['tiempo_sesion'] = time();
                    $_SESSION['idusuario'] = $usuario->getId();
                    $_SESSION['nombreus'] = $usuario->getNombre();
                }
                break;
            case 'verificarRecu':
                print_r($_POST);
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->verificarUsuarioEmp($_POST['nombreus'])) {
                    $result['exception'] = 'Autenticación incorrecto';
                } elseif (!$usuario->verificarCorreo($_POST['correoemp'])) {
                    $result['exception'] = 'Autenticaión incorrecta';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['nombreus'] = $usuario->getNombre();
                    $_SESSION['correoemp'] = $usuario->getCorreo();                   
                }
                break;
            case 'verificarPin':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->verificarPin($_POST['pin'])) {
                    $result['exception'] = 'Autenticación incorrecto';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                }
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
