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
                ORDER BY correocontac';
        $params = array("%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO contactos(telefonocontact, celularcontact, correocontac, idsucursal)
                VALUES(?,?,?,?)';
        $params = array($this->telefonocontact, $this->celularcontact, $this->correocontact, $this->idsucursal);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcontacto, telefonocontact, celularcontact, correocontac, nombresuc
                FROM contactos INNER JOIN sucursales USING(idsucursal)
                ORDER BY correocontac';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcontacto, telefonocontact, celularcontact, correocontac, idsucursal
                FROM contactos
                WHERE idcontacto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE contactos
                SET telefonocontact = ?, celularcontact = ?, correocontac = ?, idsucursal = ?
                WHERE idcontacto = ?';
        $params = array($this->telefonocontact, $this->celularcontact, $this->correocontact, $this->idsucursal, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM contactos
                WHERE idcontacto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
