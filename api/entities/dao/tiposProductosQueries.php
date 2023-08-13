<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class TiposProductosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos mediante el nombre de la bodega*/
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
                WHERE tipoproducto LIKE ?
                ORDER BY tipoproducto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    /*Método para la insercion de datos en la base de datos*/
    public function crearRegistro()
    {
        $sql = 'INSERT INTO tiposproductos(tipoproducto)
                VALUES(?)';
        $params = array($this->tipoProducto);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function leerRegistros()
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
                ORDER BY tipoproducto';
        return Database::getRows($sql);
    }

    /*Funcion para cargar un unico registro*/
    public function leerUnRegistro()
    {
        $sql = 'SELECT idtipoproducto, tipoproducto
                FROM tiposproductos
				WHERE idtipoproducto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /*Funcion para la actualizacion de un registro*/
    public function actualizarRegistro()
    {
        $sql = 'UPDATE tiposproductos 
                SET tipoproducto = ?
                WHERE idtipoproducto = ?';
        $params = array($this->tipoProducto, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para eliminar un registro de la base de datos*/
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM tiposproductos
                WHERE idtipoproducto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
