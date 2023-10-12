<?php
require_once('../helpers/database.php');

class PaisesOrigenQueries
{
    // Funcion para buscar paises de origen
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idpais, pais
                FROM paises
                WHERE pais LIKE ?
                ORDER BY pais';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearRegistro()
    {
        $sql = 'INSERT INTO paises(pais)
                VALUES(?)';
        $params = array($this->pais);
        return Database::executeRow($sql, $params);
    }

    // Función para leer los países de origen
    public function leerRegistros()
    {
        $sql = 'SELECT idpais, pais
                FROM paises
                ORDER BY pais';
        return Database::getRows($sql);
    }

    // Función para seleccionar un pais de origen
    public function leerUnRegistro()
    {
        $sql = 'SELECT idpais, pais
                FROM paises
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarRegistro()
    {
        $sql = 'UPDATE paises
                SET pais = ?
                WHERE idpais = ?';
        $params = array($this->pais, $this->idpais);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM paises
                WHERE idpais = ?';
        $params = array($this->idpais);
        return Database::executeRow($sql, $params);
    }

    /*Métodos para generar graficas*/

    public function graficaCantidadProductosPais()
    {
        $sql = 'SELECT pa.pais, COUNT(pr.idproducto) AS cantidad_productos 
            FROM paises pa 
            INNER JOIN productos pr ON pa.idpais = pr.idpais 
            WHERE pa.idpais = ? 
            GROUP BY pr.nombreprod';
        $params = array($this->idpais);
        return Database::getRows($sql, $params);
    }
}
