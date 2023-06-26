<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class entradasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarEntradas($value)
    {
        $sql = 'SELECT identrada, descripcion, idproducto, cantidad, precio, fechaentrada, idempleado
                FROM entradas
                INNER JOIN productos USING(idproducto)
                INNER JOIN empleados USING(idempleado)
                WHERE descripcion LIKE ? OR descripcion LIKE ? OR categoria LIKE ? OR nomenclatura LIKE ? OR codigo LIKE ? 
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearProducto()
    {
        $sql = 'INSERT INTO entradas(descripcion, idprodcuto, cantidad, precio, fechaentrada, , idTipoProducto, idempleado)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->descripcion, $this->producto, $this->cantidad, $this->precio, $this->fechaEntrada, $this->tipoProducto, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function leerTodo()
    {
        $sql = 'SELECT entradas.descripcion, producto.nombre, entradas.cantidad, entradas.precio, fechaentrada, idempleado
                FROM entradas 
                ';
        return Database::getRows($sql);
    }

    public function leerUnProducto()
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
                WHERE idcategoria = ? AND estadosproducto = true
                ORDER BY nombre';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function leerEstado()
    {
        $sql = 'SELECT unnest(enum_range(NULL::estadosproductos)) val, unnest(enum_range(NULL::estadosproductos)) text';
        return Database::getRows($sql);
    }

    public function leerCodigosComunes()
    {
       $sql = "SELECT concat(nomenclatura,' - ',codigo)
       FROM codigoComun
       ORDER BY nomenclatura;";
       return Database::getRows($sql);
    }
}
