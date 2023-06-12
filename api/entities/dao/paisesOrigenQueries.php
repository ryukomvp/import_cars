<?php
require_once('../../helpers/database.php');

class paisesOrigenQueries
{
    // Función para leer los países de origen
    public function leerPaisesOrigen()
    {
        $sql = 'SELECT idPais, pais
                FROM paisesDeOrigen
                ORDER BY pais';
        return Database::getRows($sql);
    }
    // Funcion para buscar paises de origen
    public function buscarPaisOrigen($value)
    {
        $sql = 'SELECT idPais, pais
                FROM paisesDeOrigen
                WHERE pais ILIKE ?
                ORDER BY pais';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearPaisOrigen()
    {
        $sql = 'INSERT INTO paisesDeOrigen(pais)
                VALUES(?)';
        $params = array($this->pais);
        return Database::executeRow($sql, $params);
    }
    // Función para seleccionar un pais de origen
    public function leerUnPaisOrigen()
    {
        $sql = 'SELECT idPais, pais
                FROM paisesDeOrigen
                WHERE idPais = ?';
        $params = array($this->idPais);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarPaisOrigen()
    {
        $sql = 'UPDATE paisesDeOrigen
                SET pais = ?
                WHERE idPais = ?';
        $params = array($this->pais);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarPaisOrigen()
    {
        $sql = 'DELETE FROM paisesDeOrigen
                WHERE idPais = ?';
        $params = array($this->idPais);
        return Database::executeRow($sql, $params);
    }
}