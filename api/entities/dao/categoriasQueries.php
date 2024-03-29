<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CategoriaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                WHERE categoria LIKE ? 
                ORDER BY categoria';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO categorias(categoria)
                VALUES(?)';
        $params = array($this->categoria);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                ORDER BY categoria';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcategoria, categoria
                FROM categorias
                WHERE idcategoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE categorias
                SET categoria = ?
                WHERE idcategoria = ?';
        $params = array($this->categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM categorias
                WHERE idcategoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function productosCategoria()
    {
        $sql = 'SELECT p.nombreprod, p.precio, c.categoria, m.modelo 
            FROM productos p
            INNER JOIN categorias c
            ON c.idcategoria = p.idcategoria
            INNER JOIN modelos m
            ON m.idmodelo = p.idmodelo
            WHERE c.idcategoria = ?
            ORDER BY p.nombreprod';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
