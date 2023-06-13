<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class categoriaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                WHERE categoria ILIKE ? 
                ORDER BY categoria';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO categorias(categoria)
                VALUES(?)';
        $params = array($this->categoria);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                ORDER BY categoria';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                WHERE idcategoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE categorias
                SET categoria = ?
                WHERE idcategoria = ?';
        $params = array($this->categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias
                WHERE idcategoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}