<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad MARCA.
*/

class MarcaQueries
{
     /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistro($value)
    {
        $sql = 'SELECT idmarca, marca
                FROM marcas
                WHERE marca ILIKE ?
                ORDER BY marca';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO marcas(marca)
                VALUES(?)';
        $params = array($this->marca);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idmarca, marca
                FROM marcas
                ORDER BY marca';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idmarca, marca
                FROM marcas
                WHERE idmarca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE marcas 
                SET marca = ?
                WHERE idmarca = ?';
        $params = array($this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM marcas
                WHERE idmarca = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}