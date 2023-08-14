<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class ContactoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcontacto, telefonocontact, celularcontact, correocontac, nombresuc
                FROM contactos INNER JOIN sucursales USING(idsucursal)
                WHERE telefonocontact LIKE ? OR celularcontact LIKE ? OR correocontac LIKE ? OR nombresuc LIKE ?
                ORDER BY nombrecajero';
        $params = array("%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO cajeros(nombrecajero, estadocajero, fechaingreso, idcaja)
                VALUES(?,?,?,?)';
        $params = array($this->nombrecajero, $this->estadocajero, $this->fechaingreso, $this->idcaja);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcajero, nombrecajero, estadocajero, fechaingreso, nombrecaja
                FROM cajeros INNER JOIN cajas USING(idcaja)
                ORDER BY nombrecajero';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcajero, nombrecajero, estadocajero, fechaingreso, idcaja
                FROM cajeros
                WHERE idcajero = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE cajeros
                SET nombrecajero = ?, estadocajero = ?, fechaingreso = ?, idcaja = ?
                WHERE idcajero = ?';
        $params = array($this->nombrecajero, $this->estadocajero, $this->fechaingreso, $this->idcaja, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM cajeros
                WHERE idcajero = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
