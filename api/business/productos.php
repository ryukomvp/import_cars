<?php
require_once('../entities/dto/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $productos = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idUsuario']) or !isset($_SESSION['idUsuario'])) {
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
            case 'buscarProducto':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $productos->leerTodo();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $productos->buscarProducto($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'crearProducto':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$productos->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio '])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setPrecioDesc($_POST['precio descuento'])) {
                    $result['exception'] = 'precio descuento incorrecto';
                } elseif (!$productos->setAnioIni($_POST['Fecha inicial'])) {
                    $result['exception'] = 'Fecha inicial incorrecto';
                } elseif (!$productos->setAnioFin($_POST['Fecha final'])) {
                    $result['exception'] = 'Fecha final incorrecto';
                } elseif (!isset($_POST['codigoscomunes'])) {
                    $result['exception'] = 'Seleccione un codigo';
                } elseif (!$productos->setCodigosComunes($_POST['codigoscomunes'])) {
                    $result['exception'] = 'codigo incorrecta';
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione un tipo de producto';
                } elseif (!$productos->setTipoProducto($_POST['tipo'])) {
                    $result['exception'] = 'Tipo de producto incorrecta';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$productos->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['modelo'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$productos->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'modelo incorrecta';
                } elseif (!isset($_POST['paisorigen'])) {
                    $result['exception'] = 'Seleccione un pais';
                } elseif (!$productos->setPais($_POST['paisorigen'])) {
                    $result['exception'] = 'pais incorrecta';
                } elseif (!$productos->setEstadoProducto($_POST['estado'])) {
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
            case 'leerUnProducto':
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $productos->leerUnProducto()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'actualizarProducto':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $productos->leerUnProducto()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del producto incorrecto';
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setPrecioDesc($_POST['precio descuento'])) {
                    $result['exception'] = 'Precio descuento incorrecto';
                } elseif (!$productos->setAnioIni($_POST['Fecha inicio'])) {
                    $result['exception'] = 'Año incorrecto';
                } elseif (!$productos->setAnioFin($_POST['Fecha inicio'])) {
                    $result['exception'] = 'Año incorrecto';
                } elseif (!isset($_POST['codigoComun'])) {
                    $result['exception'] = 'Seleccione un codigo';
                } elseif (!$productos->setCodigoComun($_POST['codigoComun'])) {
                    $result['exception'] = 'codigo incorrecta';
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione u tipo de producto';
                } elseif (!$productos->setTipoProducto($_POST['tipo'])) {
                    $result['exception'] = 'Tipo de producto incorrecta';
                } elseif (!isset($_POST['proveedor'])) {
                    $result['exception'] = 'Seleccione un proveedor';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$productos->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!isset($_POST['modelo'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$productos->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'modelo incorrecta';
                } elseif (!isset($_POST['paisorigen'])) {
                    $result['exception'] = 'Seleccione un pais';
                } elseif (!$productos->setPais($_POST['paisorigen'])) {
                    $result['exception'] = 'pais incorrecta';
                } elseif (!$productos->setEstadoProducto($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($productos->actualizarProducto($data['imagen'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif ($productos->actualizarProducto($data['imagen'])) {
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
            case 'eliminarProducto':
                if (!$productos->setId($_POST['idproducto'])) {
                    $result['exception'] = 'Id incorrecto';
                } elseif (!$data = $productos->leerUnProducto()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($productos->eliminarProducto()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'leerCodigosComunes':
                if ($result['dataset'] = $productos->leerCodigosComunes()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerEstado':
                if ($result['dataset'] = $productos->leerEstado()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
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
