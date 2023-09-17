<?php
require_once('../entities/dto/tiposUsuarios.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipoUs = new TipoUsuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'buscarRegistros':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['dataset'] = $tipoUs->leerRegistros();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $tipoUs->buscarRegistros($_POST['buscar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            // case 'crearRegistro':
            //     $_POST = Validator::validateForm($_POST);
            //     if (!$tipoUs->setTipoProducto($_POST['tipoProducto'])) {
            //         $result['exception'] = 'Tipo de producto incorrecto';
            //     } elseif ($tipoUs->crearRegistro()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Tipo de producto creado correctamente';
            //     } else {
            //         $result['exception'] = Database::getException();
            //     }
            //     break;
            case 'leerRegistros':
                if ($result['dataset'] = $tipoUs->leerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'leerUnRegistro':
                if (!$tipoUs->setId($_POST['id'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif ($result['dataset'] = $tipoUs->leerUnRegistro()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Tipo de usuario inexistente';
                }
                break;
            case 'actualizarRegistro':
                $_POST = Validator::validateForm($_POST);
                if (!$tipoUs->setId($_POST['id'])) {
                    $result['exception'] = 'ID incorrecto';
                } elseif (!$data = $tipoUs->leerUnRegistro()) {
                    $result['exception'] = 'Tipo de usuario inexistente';
                } elseif (!$tipoUs->setNombretipous($_POST['cargo'])) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif (!$tipoUs->setMarcas(isset($_POST['marca']) ? 1 : 0)) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$tipoUs->setPaisesdeorigen(isset($_POST['paisOrigen']) ? 1 : 0)) {
                    $result['exception'] = 'Pais de origen incorrecto';
                } elseif (!$tipoUs->setMonedas(isset($_POST['moneda']) ? 1 : 0)) {
                    $result['exception'] = 'Moneda incorrecta';
                } elseif (!$tipoUs->setFamilias(isset($_POST['familia']) ? 1 : 0)) {
                    $result['exception'] = 'Familia incorrecta';
                } elseif (!$tipoUs->setCategorias(isset($_POST['categoria']) ? 1 : 0)) {
                    $result['exception'] = 'Categoria incorrecta';
                } elseif (!$tipoUs->setCodigoscomunes(isset($_POST['codigoComun']) ? 1 : 0)) {
                    $result['exception'] = 'Codigo comun incorrecto';
                } elseif (!$tipoUs->setTiposproductos(isset($_POST['tipoProducto']) ? 1 : 0)) {
                    $result['exception'] = 'Tipo de producto incorrecto';
                } elseif (!$tipoUs->setCodigostransacciones(isset($_POST['codigoTransac']) ? 1 : 0)) {
                    $result['exception'] = 'Codigo de transacción incorrecto';
                } elseif (!$tipoUs->setCodigosplazos(isset($_POST['codigoPlazo']) ? 1 : 0)) {
                    $result['exception'] = 'Codigo de plazo incorrecto';
                } elseif (!$tipoUs->setSucursales(isset($_POST['sucursal']) ? 1 : 0)) {
                    $result['exception'] = 'Sucursal incorrecto';
                } elseif (!$tipoUs->setPlazos(isset($_POST['plazo']) ? 1 : 0)) {
                    $result['exception'] = 'Plazo incorrecto';
                } elseif (!$tipoUs->setContactos(isset($_POST['contacto']) ? 1 : 0)) {
                    $result['exception'] = 'Contacto incorrecto';
                } elseif (!$tipoUs->setParametros(isset($_POST['parametro']) ? 1 : 0)) {
                    $result['exception'] = 'Parametro incorrecto';
                } elseif (!$tipoUs->setProveedores(isset($_POST['proveedor']) ? 1 : 0)) {
                    $result['exception'] = 'Proveedor incorrecto';
                } elseif (!$tipoUs->setModelos(isset($_POST['modelo']) ? 1 : 0)) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif (!$tipoUs->setEmpleados(isset($_POST['empleado']) ? 1 : 0)) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$tipoUs->setClientes(isset($_POST['cliente']) ? 1 : 0)) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$tipoUs->setUsuarios(isset($_POST['usuario']) ? 1 : 0)) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$tipoUs->setCajas(isset($_POST['caja']) ? 1 : 0)) {
                    $result['exception'] = 'Caja incorrecta';
                } elseif (!$tipoUs->setCajeros(isset($_POST['cajero']) ? 1 : 0)) {
                    $result['exception'] = 'Cajero incorrecto';
                } elseif (!$tipoUs->setVendedores(isset($_POST['vendedor']) ? 1 : 0)) {
                    $result['exception'] = 'Vendedor incorrecto';
                } elseif (!$tipoUs->setBodegas(isset($_POST['bodega']) ? 1 : 0)) {
                    $result['exception'] = 'Bodega incorrecta';
                } elseif (!$tipoUs->setFamiliasbodegas(isset($_POST['familiaBod']) ? 1 : 0)) {
                    $result['exception'] = 'Familia de bodega incorrecta';
                } elseif (!$tipoUs->setProductos(isset($_POST['producto']) ? 1 : 0)) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$tipoUs->setEncabezadostransacciones(isset($_POST['encaTransac']) ? 1 : 0)) {
                    $result['exception'] = 'Encabezado de transacción incorrecto';
                } elseif (!$tipoUs->setDetallestransacciones(isset($_POST['detalleTransac']) ? 1 : 0)) {
                    $result['exception'] = 'Detalle de transacción incorrecto';
                } elseif (!$tipoUs->setTiposusuarios(isset($_POST['tipoUsuario']) ? 1 : 0)) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif ($tipoUs->actualizarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'eliminarRegistro':
                if (!$tipoUs->setId($_POST['idtipousuario'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!$data = $tipoUs->leerUnRegistro()) {
                    $result['exception'] = 'Tipo de usuario inexistente';
                } elseif ($tipoUs->eliminarRegistro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de usuario eliminado correctamente';
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
