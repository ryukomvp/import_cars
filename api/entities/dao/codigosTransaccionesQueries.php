<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CodigosTransaccionesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcodigotransaccion, codigo, nombrecodigo
                FROM codigostransacciones
                WHERE nombrecodigo LIKE ? 
                ORDER BY nombrecodigo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO codigostransacciones(codigo, nombrecodigo)
                VALUES(?,?)';
        $params = array($this->codigo, $this->nombrecodigo);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcodigotransaccion, codigo, nombrecodigo
                FROM codigostransacciones
                ORDER BY nombrecodigo';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcodigotransaccion, codigo, nombrecodigo
                FROM codigostransacciones
                WHERE idcodigotransaccion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE codigostransacciones
                SET codigo = ?, nombrecodigo = ?
                WHERE idcodigotransaccion = ?';
        $params = array( $this->codigo, $this->nombrecodigo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM codigostransacciones
                WHERE idcodigotransaccion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
