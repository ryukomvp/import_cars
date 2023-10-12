<?php
require_once('../helpers/database.php');
/*
*  Clase para manejar el acceso a datos de la entidad de BODEGAS
*/
class BodegasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos
     mediante el nombre de la bodega*/
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idbodega, numerobod, bodegas.direccionbod, nombresuc
             FROM bodegas INNER JOIN sucursales ON bodegas.idsucursal = sucursales.idsucursal
             WHERE  bodegas.direccionbod LIKE ? OR nombresuc LIKE ?
             ORDER BY numerobod';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*Método para la insercion de datos en la base de datos*/
    public function crearRegistro()
    {
        $sql = 'INSERT INTO bodegas(numerobod, direccionbod, idsucursal)
            VALUES(?, ?, ?)';
        $params = array($this->numerobodega, $this->direccion, $this->sucursal);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function leerRegistros()
    {
        $sql = 'SELECT idbodega, numerobod, bodegas.direccionbod, nombresuc
            FROM bodegas INNER JOIN sucursales ON bodegas.idsucursal = sucursales.idsucursal
            ORDER BY numerobod';
        return Database::getRows($sql);
    }


    /*Funcion para cargar un unico registro*/
    public function leerUnRegistro()
    {
        $sql = 'SELECT idbodega, numerobod, direccionbod, idsucursal
             FROM bodegas
             WHERE idbodega = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /*Funcion para la actualizacion de un registro*/
    public function actualizarRegistro()
    {
        $sql = 'UPDATE bodegas
            SET  numerobod = ?, direccionbod = ?, idsucursal = ?
            WHERE idbodega = ?';
        $params = array($this->numerobodega, $this->direccion, $this->sucursal, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para eliminar un registro de la base de datos*/
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM bodegas
            WHERE idbodega = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para cargar los registros en el select y mostrarlos*/
    public function cargarSucursal()
    {
        $sql = 'SELECT idsucursal, nombresuc, telefonosuc, correosuc, direccionsuc
            FROM sucursales
            ORDER BY nombresuc';
        return Database::getRows($sql);
    }
}
