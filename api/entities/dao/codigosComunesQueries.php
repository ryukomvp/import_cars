<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CodigoComunQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcodigocomun, codigo
                FROM codigoscomunes
                WHERE codigo LIKE ? 
                ORDER BY codigo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO codigoscomunes(codigo)
                VALUES(?)';
        $params = array($this->codigo);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcodigocomun, codigo
                FROM codigoscomunes
                ORDER BY codigo';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcodigocomun, codigo
                FROM codigoscomunes
                WHERE idcodigocomun = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE codigoscomunes
                SET codigo = ?
                WHERE idcodigocomun = ?';
        $params = array( $this->codigo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM codigoscomunes
                WHERE idcodigocomun = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
