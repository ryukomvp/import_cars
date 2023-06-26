<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class productosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarProducto($value)
    {
        $sql = 'SELECT productos.idproducto, productos.nombre, productos.descripcion, productos.precio, productos.anio, codigocomun.nomenclatura, codigocomun.codigo, tiposproductos.tipoproducto, proveedores.nombre as proveedor, categorias.categoria, modelos.modelo, paisesdeorigen.pais, productos.estadoproducto
                FROM productos 
                INNER JOIN categorias ON productos.idcategoria = categorias.idcategoria
                INNER JOIN codigoComun ON productos.idcodigocomun = codigocomun.idcodigocomun
                INNER JOIN tiposProductos ON productos.idtipoproducto = tiposproductos.idtipoproducto
                INNER JOIN proveedores ON productos.idproveedor = proveedores.idproveedor
                INNER JOIN modelos ON productos.idmodelo = modelos.idmodelo  
                INNER JOIN paisesdeorigen ON productos.idpais = paisesdeorigen.idpais
                WHERE  productos.nombre LIKE ? OR productos.descripcion LIKE ? OR categorias.categoria  LIKE ? OR codigoComun.nomenclatura  LIKE ? OR CAST (codigoComun.codigo as varchar) LIKE ?
                ORDER BY productos.nombre';  
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearProducto()
    {
        // , $_SESSION['idUsuario']
        $sql = 'INSERT INTO productos(nombre, imagen, descripcion, precio, anio, idcodigocomun, idtipoproducto, idproveedor, idcategoria, idmodelo, idpais, estadoproducto)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->anio, $this->idCodigoComun, $this->idTipoProducto, $this->idProveedor, $this->idCategoria, $this->idModelo, $this->idPais, $this->estadoProducto);
        return Database::executeRow($sql, $params);
    }

    public function leerTodo()
    {
        $sql = 'SELECT p.idproducto, p.nombre, p.imagen, p.descripcion, p.precio, p.anio, a.nomenclatura, a.codigo, b.tipoproducto, m.nombre as proveedor, c.categoria, n.modelo, s.pais, p.estadoproducto
                FROM productos p
                INNER JOIN categorias c ON p.idcategoria = c.idcategoria 
                INNER JOIN proveedores m ON p.idproveedor = m.idproveedor 
                INNER JOIN codigoComun a ON p.idcodigocomun = a.idcodigocomun
                INNER JOIN tiposproductos b ON p.idtipoproducto = b.idtipoproducto
                INNER JOIN modelos n ON p.idmodelo = n.idmodelo
                INNER JOIN paisesdeorigen s ON p.idpais = s.idpais
                ORDER BY p.nombre;';
        return Database::getRows($sql);
    }

    public function leerUnProducto()
    {
        $sql = 'SELECT idproducto,nombre, imagen, descripcion, precio, anio, idcodigocomun, idtipoproducto, idproveedor, idcategoria, idmodelo, idpais, estadoproducto
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
                SET nombre = ?, imagen= ?, descripcion= ?, precio= ?, anio= ?, idcodigocomun= ?, idtipoproducto= ?, idproveedor= ?, idcategoria= ?, idmodelo= ?, idpais= ?, estadoproducto= ?
                WHERE idproducto = ?';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->anio, $this->idCodigoComun, $this->idTipoProducto, $this->idProveedor, $this->idCategoria, $this->idModelo, $this->idPais, $this->estadoProducto, $this->id);
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
       $sql = "SELECT idcodigocomun, concat(nomenclatura,' - ',codigo)
       FROM codigocomun
       ORDER BY nomenclatura";
       return Database::getRows($sql);
    }
}
