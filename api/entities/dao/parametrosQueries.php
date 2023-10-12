<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class ParametrosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idparametro, nombreemp, direccionemp, porcentajeiva, registro, giroempresa, nit, dui
                FROM parametros INNER JOIN contactos USING (idcontacto)
                WHERE nombreemp LIKE ? OR direccionemp LIKE ? OR nit LIKE ? OR dui LIKE ? OR correocontact LIKE ? 
                ORDER BY nombreemp';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO parametros(nombreemp, direccionemp, porcentajeiva, registro, giroempresa, nit, dui, idcontacto)
                VALUES(?,?,?,?,?,?,?,?)';
        $params = array($this->nombreemp, $this->direccionemp, $this->porcentaje, $this->registro, $this->giroempresa, $this->nit, $this->dui, $this->idcontacto);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idparametro, nombreemp, direccionemp, porcentajeiva, registro, giroempresa, nit, dui
        FROM parametros INNER JOIN contactos USING (idcontacto)
        ORDER BY nombreemp';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idparametro, nombreemp, direccionemp, porcentajeiva, registro, giroempresa, nit, dui, idcontacto
                FROM parametros
                WHERE idparametro = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE parametros
                SET nombreemp = ?, direccionemp = ?, porcentajeiva = ?, registro = ?, giroempresa = ?, nit = ?, dui = ?, idcontacto = ?
                WHERE idparametro = ?';
        $params = array($this->nombreemp, $this->direccionemp, $this->porcentaje, $this->registro, $this->giroempresa, $this->nit, $this->dui, $this->idcontacto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM parametros
                WHERE idparametro = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
