<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class tiposProductosQueries
{
    /*
    *   Métodos para realizar operaciones de gestión en la tabla usuarios
    */
    public function buscarTiposProductos($value)
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
                WHERE tipoproducto ILIKE ?
                ORDER BY idtipoproducto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearTiposProductos()
    {
        $sql = 'INSERT INTO tiposproductos(tipoproducto)
                VALUES(?)';
        $params = array($this->tipoProducto);
        return Database::executeRow($sql, $params);
    }

    public function leerTiposProductos()
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
                ORDER BY idtipoproducto';
        return Database::getRows($sql);
    }

    public function leerTipoProducto()
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
				WHERE idtipoproducto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarTiposProductos()
    {
        $sql = 'UPDATE tiposproductos 
                SET tipoproducto = ?
                WHERE idtipoproducto = ?';
        $params = array($this->tipoProducto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarTiposProductos()
    {
        $sql = 'DELETE FROM tiposproductos
                WHERE idtipoproducto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
