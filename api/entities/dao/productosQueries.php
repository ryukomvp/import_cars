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
        $sql = 'SELECT productos.idproducto, productos.imagen, productos.nombreprod, productos.descripcionprod, productos.precio, productos.preciodesc, productos.anioinicial, productos.aniofinal, codigoscomunes.codigo, tiposproductos.tipoproducto, categorias.categoria, modelos.modelo, paisesdeorigen.pais, productos.estadoproducto 
        FROM productos 
        INNER JOIN categorias ON productos.idcategoria = categorias.idcategoria 
        INNER JOIN codigoscomunes ON productos.idcodigocomun = codigoscomunes.idcodigocomun 
        INNER JOIN tiposproductos ON productos.idtipoproducto = tiposproductos.idtipoproducto 
        INNER JOIN modelos ON productos.idmodelo = modelos.idmodelo 
        INNER JOIN paisesdeorigen ON productos.idpais = paisesdeorigen.idpais 
        WHERE productos.nombreprod LIKE ? OR productos.descripcionprod LIKE ? OR categorias.categoria  LIKE ? OR codigoscomunes.codigo LIKE ? OR modelos.modelo LIKE ? OR paisesdeorigen.pais LIKE ?
        ORDER BY productos.nombreprod';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearProducto()
    {
        // , $_SESSION['idUsuario']
        $sql = 'INSERT INTO productos(nombreprod, imagen, descripcionprod, precio, preciodesc, anioinicial, aniofinal, idcodigocomun, idtipoproducto, idcategoria, idmodelo, idpais, estadoproducto)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->precioDesc, $this->anioIni, $this->anioFin, $this->idCodigosComunes, $this->idTipoProducto, $this->idCategoria, $this->idModelo, $this->idPais, $this->estadoProducto);
        return Database::executeRow($sql, $params);
    }

    public function leerTodo() 
    {
        $sql = 'SELECT p.idproducto, p.nombreprod, p.imagen, p.descripcionprod, p.precio, p.preciodesc , p.anioinicial, p.aniofinal, a.codigo, b.tipoproducto, c.categoria, n.modelo, s.pais, p.estadoproducto
                FROM productos p
                INNER JOIN categorias c ON p.idcategoria = c.idcategoria 
                INNER JOIN codigoscomunes a ON p.idcodigocomun = a.idcodigocomun
                INNER JOIN tiposproductos b ON p.idtipoproducto = b.idtipoproducto
                INNER JOIN modelos n ON p.idmodelo = n.idmodelo
                INNER JOIN paisesdeorigen s ON p.idpais = s.idpais
                ORDER BY p.nombreprod;';
        return Database::getRows($sql);
    }

    public function leerUnProducto()
    {
        $sql = 'SELECT idproducto,nombreprod, imagen, descripcionprod, precio, preciodesc, anioinicial, aniofinal, idcodigocomun, idtipoproducto, idcategoria, idmodelo, idpais, estadoproducto
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
                SET nombreprod = ?, imagen = ?, descripcionprod = ?, precio = ?, preciodesc = ?, anioinicial = ?, aniofinal = ?, idcodigocomun = ?, idtipoproducto = ?, idcategoria = ?, idmodelo = ?, idpais = ?, estadoproducto = ?
                WHERE idproducto = ?';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->precioDesc, $this->anioIni, $this->anioFin, $this->idCodigosComunes, $this->idTipoProducto, $this->idCategoria, $this->idModelo, $this->idPais, $this->estadoProducto, $this->id);
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
        $sql = 'SELECT idproducto, nombreprod, imagen,  descripcioprod, precio, preciodesc
                FROM productos INNER JOIN categorias USING(idcategoria)
                WHERE idcategoria = ? AND estadosproducto = true
                ORDER BY nombreprod';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function leerEstado()
    {
        $estados = array (array('Escaso', 'Escaso'), array('Existente', 'Existente'), array('Sin existencias', 'Sin existencias'));
        return $estados;
    }

    public function leerCodigosComunes()
    {
        $sql = "SELECT idcodigocomun, codigo
       FROM codigoscomunes
       ORDER BY codigo";
        return Database::getRows($sql);
    }

    
}
