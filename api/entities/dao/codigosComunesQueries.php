<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class codigoComunQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarCodigoComun($value)
    {
        $sql = 'SELECT idcodigocomun, nomenclatura, codigo
                FROM codigocomun
                WHERE nomenclatura ILIKE ? 
                ORDER BY nomenclatura';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearCodigoComun()
    {
        $sql = 'INSERT INTO codigocomun(nomenclatura, codigo)
                VALUES(?,?)';
        $params = array($this->nomenclatura, $this->codigo);
        return Database::executeRow($sql, $params);
    }

    public function leerCodigosComunes()
    {
        $sql = 'SELECT idcodigocomun, nomenclatura, codigo
                FROM codigoComun
                ORDER BY nomenclatura';
        return Database::getRows($sql);
    }

    public function leerUnCodigoComun()
    {
        $sql = 'SELECT idcodigocomun, nomenclatura, codigo
                FROM codigocomun
                WHERE idcodigocomun = ?';
        $params = array($this->idcodigocomun);
        return Database::getRow($sql, $params);
    }

    public function actualizarCodigoComun()
    {
        $sql = 'UPDATE codigocomun
                SET nomenclatura = ?, codigo = ?
                WHERE idcodigocomun = ?';
        $params = array($this->nomenclatura, $this->codigo, $this->idcodigocomun);
        return Database::executeRow($sql, $params);
    }

    public function eliminarCodigoComun()
    {
        $sql = 'DELETE FROM codigocomun
                WHERE idcodigocomun = ?';
        $params = array($this->idcodigocomun);
        return Database::executeRow($sql, $params);
    }
}