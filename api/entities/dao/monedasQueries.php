<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class MonedasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                WHERE moneda ILIKE ? 
                ORDER BY moneda';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO monedas(moneda)
                VALUES(?)';
        $params = array($this->moneda);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                ORDER BY moneda';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                WHERE idmoneda = ?';
        $params = array($this->idmoneda);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE monedas
                SET moneda = ?
                WHERE idmoneda = ?';
        $params = array($this->moneda, $this->idmoneda);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM monedas
                WHERE idmoneda = ?';
        $params = array($this->idmoneda);
        return Database::executeRow($sql, $params);
    }
}