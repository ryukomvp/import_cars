<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad MODELO.
*/

class ModeloQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idmodelo, modelo, marca
                FROM modelos INNER JOIN marcas USING(idmarca)
                WHERE modelo ILIKE ?
                ORDER BY modelo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO modelos(modelo, idmarca)
                VALUES(?, ?)';
        $params = array($this->modelo, $this->marca);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idmodelo, modelo, marca
                FROM modelos INNER JOIN marcas USING(idmarca)
                ORDER BY modelo';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idmodelo, modelo, idmarca
                FROM modelos
                WHERE idmodelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE modelos 
                SET modelo = ?, idmarca = ?
                WHERE idmodelo = ?';
        $params = array($this->modelo, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM modelos
                WHERE idmodelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function cargarMarcas()
    {
        $sql = 'SELECT idmarca, marca FROM marcas
                ORDER BY marca';
        return Database::getRows($sql);
    }
}
