<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ProductosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarProducto($value)
    {
        $sql = 'SELECT idproducto, nombre, descripcion, precio, anio, idcodigocomun, idtipoproducto, idproveedor, idcategoria, idmodelo, idpais, estadoproducto
                FROM productos 
                INNER JOIN categorias USING(idcategoria)
                INNER JOIN codigocomun USING(idcodigocomun)
                WHERE nombre LIKE ? OR descripcion LIKE ? OR categoria LIKE ? OR nomenclatura LIKE ? OR codigo LIKE ? 
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearProducto()
    {
        // , $_SESSION['id_usuario_privado']
        $sql = 'INSERT INTO producto(nombre, imagen, descripcion, precio, anio, idCodigoComun, idTipoProducto, idProveedor, idCategoria, idModelo, idPais, estadoProducto)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->anio, $this->codigo, $this->tipoProducto, $this->proveedor, $this->categoria, $this->modelo, $this->pais, $this->estadoProducto);
        return Database::executeRow($sql, $params);
    }

    public function leerTodo()
    {
        $sql = 'SELECT nombre, imagen, descripcion, precio, anio, idCodigoComun, idTipoProducto, idProveedor, idCategoria, idModelo, idPais, estadoProducto
                FROM productos INNER JOIN categorias USING(idcategoria)
                ORDER BY nombre';
        return Database::getRows($sql);
    }

    public function leerUno()
    {
        $sql = 'SELECT idproducto,nombre, imagen, descripcion, precio, anio, idCodigoComun, idTipoProducto, idProveedor, idCategoria, idModelo, idPais, estadoProducto
                FROM productos
                WHERE idproducto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarProducto($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET nombre = ?, imagen= ?, descripcion= ?, precio,= ? anio= ?, idCodigoComun= ?, idTipoProducto= ?, idProveedor= ?, idCategoria= ?, idModelo= ?, idPais= ?, estadoProducto= ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->anio, $this->codigo, $this->tipoProducto, $this->proveedor, $this->categoria, $this->modelo, $this->pais, $this->estadoProducto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarProducto()
    {
        $sql = 'DELETE FROM productos
                WHERE idproducto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerProductoCategoria()
    {
        $sql = 'SELECT idproducto, nombre, foto,  descripcio, precio
                FROM productos INNER JOIN categorias USING(idcategoria)
                WHERE idcategoria = ? AND estadoproducto = true
                ORDER BY nombre';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function leerEstado()
    {
        $sql = 'SELECT unnest(enum_range(NULL::estadoproducto)) val, unnest(enum_range(NULL::estadoproducto)) text';
        return Database::getRows($sql);
    }

    public function leerCodigo()
    {
        $sql = 'SELECT nomenclatura, codigo from codigoComun';
        return Database::getRows($sql);
    }
}
