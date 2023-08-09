<?php
require_once('../helpers/database.php');

class PaisesOrigenQueries
{
    // Funcion para buscar paises de origen
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                WHERE pais LIKE ?
                ORDER BY pais';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearRegistro()
    {
        $sql = 'INSERT INTO paisesdeorigen(pais)
                VALUES(?)';
        $params = array($this->pais);
        return Database::executeRow($sql, $params);
    }

    // Función para leer los países de origen
    public function leerRegistros()
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                ORDER BY pais';
        return Database::getRows($sql);
    }

    // Función para seleccionar un pais de origen
    public function leerUnRegistro()
    {
        $sql = 'SELECT idpais, pais
                FROM paisesdeorigen
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarRegistro()
    {
        $sql = 'UPDATE paisesdeorigen
                SET pais = ?
                WHERE idpais = ?';
        $params = array($this->pais, $this->idpais);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM paisesdeorigen
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::executeRow($sql, $params);
    }
}
