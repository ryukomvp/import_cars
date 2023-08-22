<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CodigosPlazosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcodigoplazo, plazo, dias
                FROM codigosplazos
                WHERE plazo LIKE ? 
                ORDER BY plazo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO codigosplazos(plazo, dias)
                VALUES(?,?)';
        $params = array($this->plazo, $this->dias);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcodigoplazo, plazo, dias
                FROM codigosplazos
                ORDER BY plazo';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcodigoplazo, plazo, dias
                FROM codigosplazos
                WHERE idcodigoplazo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE codigosplazos
                SET plazo = ?, dias = ?
                WHERE idcodigoplazo = ?';
        $params = array( $this->plazo, $this->dias, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM codigosplazos
                WHERE idcodigoplazo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Generar Gráfica//

    public function graficaCantidadPlazos()
    {
        $sql = 'SELECT codigosplazos.plazo, COUNT(plazos.idcodigoplazo) AS cantidad_plazos
            FROM plazos
            INNER JOIN codigosplazos ON plazos.idcodigoplazo = codigosplazos.idcodigoplazo
            WHERE idcodigoplazo = ?
            GROUP BY codigosplazos.plazo';
        $params(this->id);
        return Database::getRows($sql, $params);
    }
}
