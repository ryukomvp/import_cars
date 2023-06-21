<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class monedasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarMoneda($value)
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                WHERE moneda ILIKE ? 
                ORDER BY moneda';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearMoneda()
    {
        $sql = 'INSERT INTO monedas(moneda)
                VALUES(?)';
        $params = array($this->moneda);
        return Database::executeRow($sql, $params);
    }

    public function leerMoneda()
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                ORDER BY moneda';
        return Database::getRows($sql);
    }

    public function leerUnaMoneda()
    {
        $sql = 'SELECT idmoneda, moneda
                FROM monedas
                WHERE idmoneda = ?';
        $params = array($this->idmoneda);
        return Database::getRow($sql, $params);
    }

    public function actualizarMoneda()
    {
        $sql = 'UPDATE monedas
                SET moneda = ?
                WHERE idmoneda = ?';
        $params = array($this->moneda, $this->idmoneda);
        return Database::executeRow($sql, $params);
    }

    public function eliminarMoneda()
    {
        $sql = 'DELETE FROM monedas
                WHERE idmoneda = ?';
        $params = array($this->idmoneda);
        return Database::executeRow($sql, $params);
    }
}