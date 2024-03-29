<?php
require_once('../helpers/database.php');
/*
*  Clase para manejar el acceso a datos de la entidad de SUCURSALES
*/
class sucursalesqueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos
     mediante el nombre o la direccion de la sucursal*/
    public function searchRows($value)
    {
        $sql = 'SELECT idsucursal, nombresuc, telefonosuc, correosuc, direccionsuc
            FROM sucursales
            WHERE nombresuc LIKE ? OR telefonosuc LIKE ? OR direccionsuc LIKE ?
            ORDER BY nombresuc';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*Método para la insercion de datos en la base de datos*/
    public function createRow()
    {
        $sql = 'INSERT INTO sucursales(nombresuc, telefonosuc, correosuc, direccionsuc)
            VALUES(?, ?, ?, ?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->direccion);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function readAll()
    {
        $sql = 'SELECT idsucursal, nombresuc, telefonosuc, correosuc, direccionsuc
            FROM sucursales
            ORDER BY nombresuc';
        return Database::getRows($sql);
    }

    /*Funcion para cargar un unico registro*/
    public function readOne()
    {
        $sql = 'SELECT idsucursal, nombresuc, telefonosuc, correosuc, direccionsuc
            FROM sucursales
            WHERE idsucursal = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /*Funcion para la actualizacion de un registro*/
    public function updateRow()
    {
        $sql = 'UPDATE sucursales
            SET  nombresuc = ?, telefonosuc = ?, correosuc = ?, direccionsuc = ?
            WHERE idsucursal = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->direccion, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para eliminar un registro de la base de datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM sucursales
            WHERE idsucursal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
