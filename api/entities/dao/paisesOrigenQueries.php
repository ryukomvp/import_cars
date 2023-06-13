<?php
require_once('../helpers/database.php');

class paisesOrigenQueries
{
    // Función para leer los países de origen
    public function leerPaisesOrigen()
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                ORDER BY pais';
        return Database::getRows($sql);
    }
    // Funcion para buscar paises de origen
    public function buscarPaisOrigen($value)
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                WHERE pais ILIKE ?
                ORDER BY pais';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearPaisOrigen()
    {
        $sql = 'INSERT INTO paisesdeorigen(pais)
                VALUES(?)';
        $params = array($this->pais);
        return Database::executeRow($sql, $params);
    }
    // Función para seleccionar un pais de origen
    public function leerUnPaisOrigen()
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarPaisOrigen()
    {
        $sql = 'UPDATE paisesdeorigen
                SET pais = ?
                WHERE idpais = ?';
        $params = array($this->pais, $this->idpais);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarPaisOrigen()
    {
        $sql = 'DELETE FROM paisesdeorigen
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::executeRow($sql, $params);
    }
}