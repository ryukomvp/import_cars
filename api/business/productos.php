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
    if (isset($_SESSION['id_usuario_privado']) or 1) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $product->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $product->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$product->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$product->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$product->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$product->setPrecio($_POST['precio'])){
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$product->setCodigo($_POST['codigo'])) {
                    $result['exception'] = 'codigo incorrecto';
                } elseif (!$product->setDimensiones($_POST['dimensiones'])) {
                    $result['exception'] = 'dimensiones incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$product->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['tipo_material'])) {
                    $result['exception'] = 'Seleccione un material';
                } elseif (!$product->setMaterial($_POST['tipo_material'])) {
                    $result['exception'] = 'Material incorrecta';
                } elseif (!isset($_POST['proveedor'])) {
                    $result['exception'] = 'Seleccione un proveedor';
                } elseif (!$product->setProveedor($_POST['proveedor'])) {
                    $result['exception'] = 'Proveedor incorrecta';
                } elseif (!$product->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$product->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'existencia incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif ($product->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $product->getRuta(), $product->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$product->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $product->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'update':

                $_POST = Validator::validateForm($_POST);
                if (!$product->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $product->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$product->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$product->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$product->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$product->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$product->setCodigo($_POST['codigo'])) {
                    $resut['exception'] = 'codigo incorrecto';
                } elseif (!$product->setDimensiones($_POST['dimensiones'])) {
                    $result['exception'] = 'dimensiones incorrecto';
                } elseif (!$product->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$product->setMaterial($_POST['tipo_material'])) {
                    $result['exception'] = 'Seleccione un material';
                } elseif (!$product->setProveedor($_POST['proveedor'])) {
                    $result['exception'] = 'Seleccione un proveedor';
                } elseif (!$product->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$product->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'existencia incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($product->updateRow($data['foto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif ($product->updateRow($data['foto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $product->getRuta(), $product->getImagen())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$product->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $product->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($product->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($product->getRuta(), $data['foto'])) {
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
