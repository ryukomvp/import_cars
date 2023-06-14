<?php
require_once('../../entities/dto/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $productos = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario']) OR !isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'leerTodo':
                if ($result['dataset'] = $productos->leerTodo()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $productos->buscarProducto($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crear':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$productos->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])){
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setAnio($_POST['anio'])){
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$productos->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['tipo_material'])) {
                    $result['exception'] = 'Seleccione un material';
                } elseif (!isset($_POST['proveedor'])) {
                    $result['exception'] = 'Seleccione un proveedor';
                } elseif (!$productos->setProveedor($_POST['proveedor'])) {
                    $result['exception'] = 'Proveedor incorrecta';
                } elseif (!$productos->setEstado(isset($_POST['estadoproducto']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif ($productos->crearProducto()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $productos->getRuta(), $productos->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'leerUno':
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $productos->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'Actualizar':

                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$productos->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setCodigo($_POST['codigo'])) {
                    $resut['exception'] = 'codigo incorrecto';
                } elseif (!$productos->setDimensiones($_POST['dimensiones'])) {
                    $result['exception'] = 'dimensiones incorrecto';
                } elseif (!$productos->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$productos->setMaterial($_POST['tipo_material'])) {
                    $result['exception'] = 'Seleccione un material';
                } elseif (!$productos->setProveedor($_POST['proveedor'])) {
                    $result['exception'] = 'Seleccione un proveedor';
                } elseif (!$productos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$productos->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'existencia incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($productos->updateRow($data['foto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif ($productos->updateRow($data['foto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $productos->getRuta(), $productos->getImagen())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'Eliminar':
                if (!$productos->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($productos->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($productos->getRuta(), $data['foto'])) {
                        $result['message'] = 'Producto eliminado correctamente';
                    } else {
                        $result['message'] = 'Producto eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
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
