<?php
// Se incluye la clase para la transferencia y acceso a datos.
require_once('../entities/dto/codigosComun.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if(isset($_GET['action'])){
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $codigo = new codigo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if(isset($_SESSION['idusuario']) OR !isset($_SESSION['idusuario'])){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']) {
            case 'leerCategorias':
                if ($result['dataset'] = $categoria->leerCodigos()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'buscar':
                $_POST = Validator::validateForm($_POST);
                   if ($_POST['search'] == '') {
                       $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $categoria->buscarCodigos($_POST['search'])) {
                       $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                 break;
            case 'crear':
                $_POST = Validator::validateForm($_POST);
                if (!$categoria->setCategoria($_POST['categoria'])){
                    $result['exception'] = 'Nombre incorrecto'; 
                } elseif ($categoria->crearCategoria()){
                    $result['status'] = 1;
                    $result['message'] = 'Marca creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;   
            case 'leerCategoria':
                if (!$categoria->setId($_POST['idcategoria'])) {
                        $result['exception'] = 'Categoria incorrecta';
                } elseif ($result['dataset'] = $categoria->leerCategoria()) {
                       $result['status'] = 1;
                } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                } else {
                       $result['exception'] = 'Categoria inexistente';
                }
                break;
            case 'actualizar':
                $_POST = Validator::validateForm($_POST);
               if (!$categoria->setId($_POST['id'])) {
                    $result['exception'] = 'Categoria incorrecta';
                } elseif (!$data = $categoria->leerCategoria()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$categoria->setCategoria($_POST['categoria'])) {
                     $result['exception'] = 'Nombre incorrecto';
                } elseif ($categoria->actualizarCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminar':
                if (!$categoria->setId($_POST['idcategoria'])) {
                    $result['exception'] = 'Id incorrecto';
                } elseif (!$data = $categoria->leerCategoria()) {
                    $result['exception'] = 'Categoria inexistente';
                } elseif ($categoria->eliminarCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria eliminada correctamente';
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