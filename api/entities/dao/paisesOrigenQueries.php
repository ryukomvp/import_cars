<?php
require_once('../helpers/database.php');

class PaisesOrigenQueries
{
    // Funcion para buscar paises de origen
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idpais,nomenclatura, pais
                FROM paises
                WHERE nomenclatura LIKE ? OR pais LIKE ?
                ORDER BY pais';
        $params = array("%$value%","%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearRegistro()
    {
        $sql = 'INSERT INTO paises(nomenclatura,pais)
                VALUES(?,?)';
        $params = array($this->nomenclatura, $this->pais);
        return Database::executeRow($sql, $params);
    }

    // Función para leer los países de origen
    public function leerRegistros()
    {
        $sql = 'SELECT idpais, pais, nomenclatura
                FROM paises
                ORDER BY pais';
        return Database::getRows($sql);
    }

    // Función para seleccionar un pais de origen
    public function leerUnRegistro()
    {
        $sql = 'SELECT idpais,nomenclatura, pais
                FROM paises
                WHERE idpais = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarRegistro()
    {
        $sql = 'UPDATE paises
                SET nomenclatura = ?,  pais = ?
                WHERE idpais = ?';
        $params = array($this->nomenclatura, $this->pais, $this->id);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM paises
                WHERE idpais = ?';
        $params = array($this->id);
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
