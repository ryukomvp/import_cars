<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad MODELO.
*/

class modeloQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_modelo, nombre_modelo, numero_de_modelo, id_marca
                FROM modelos
                WHERE nombre_modelo ILIKE ? OR numero_de_modelo ILIKE ?
                ORDER BY nombre_modelo';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO modelos(nombre_modelo, numero_de_modelo, id_marca)
                VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->numeromodelo, $this->marca);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_modelo, nombre_modelo, numero_de_modelo, id_marca
                FROM modelos
                ORDER BY nombre_modelo';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_modelo, nombre_modelo, numero_de_modelo, id_marca
                FROM modelos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE modelos 
                SET nombre_modelo = ?, numero_de_modelo = ?, id_marca = ?
                WHERE id_modelo = ?';
        $params = array($this->nombre, $this->numeromodelo, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM modelos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function cargarMarca(){
        $sql = 'SELECT id_marca, nombre_marca
        FROM marcas';
        return Database::getRows($sql);
    }
}