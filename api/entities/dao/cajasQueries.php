<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CajaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcaja, nombrecaja, nombreequipo, serieequipo, modeloequipo, nombresuc, nombreus
                FROM cajas INNER JOIN sucursales USING(idsucursal) INNER JOIN usuarios USING(idusuario)
                WHERE nombrecaja LIKE ? OR nombreequipo LIKE ? OR serieequipo LIKE ? OR modeloequipo LIKE ? OR nombresuc LIKE ? OR nombreus LIKE ? 
                ORDER BY nombrecaja';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO cajas(nombrecaja, nombreequipo, serieequipo, modeloequipo, idsucursal, idusuario)
                VALUES(?,?,?,?,?,?)';
        $params = array($this->nombrecaja,$this->nombreequipo, $this->serieequipo, $this->modeloequipo, $this->idsucursal, $this->idusuario);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcaja, nombrecaja, nombreequipo, serieequipo, modeloequipo, nombresuc, nombreus
                FROM cajas INNER JOIN sucursales USING(idsucursal) INNER JOIN usuarios USING(idusuario)
                ORDER BY nombrecaja';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcaja, nombrecaja, nombreequipo, serieequipo, modeloequipo, idsucursal, idusuario
                FROM cajas
                WHERE idcaja = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE cajas
                SET nombrecaja = ?, nombreequipo = ?, serieequipo = ?, modeloequipo = ?, idsucursal = ?, idusuario = ?
                WHERE idcaja = ?';
        $params = array($this->nombrecaja, $this->nombreequipo, $this->serieequipo, $this->modeloequipo, $this->idsucursal, $this->idusuario, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM cajas
                WHERE idcaja = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
