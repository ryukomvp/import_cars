<?php
require_once('../helpers/database.php');
/*
*  Clase para manejar el acceso a datos de la entidad de BODEGAS
*/
class bodegasqueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos
     mediante el nombre de la bodega*/
     public function searchRows($value)
     {
         $sql = 'SELECT idbodega, numerobodega, direccion
             FROM bodegas
             WHERE direccion ILIKE ?
             ORDER BY direccion';
         $params = array("%$value%");
         return Database::getRows($sql, $params);    
     }

     /*Método para la insercion de datos en la base de datos*/
    public function createRow()
    {
        $sql = 'INSERT INTO bodegas(numerobodega, direccion, idsucursal)
            VALUES(?, ?, ?)';
        $params = array($this->numerobodega, $this->direccion, $this->sucursal);
        return Database::executeRow($sql, $params);
    }
    
    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function readAll()
    {
        $sql = 'SELECT idbodega, numerobodega, direccion
            FROM bodegas
            ORDER BY numerobodega';
        return Database::getRows($sql);
    }

    /*Funcion para cargar los registros en el select y mostrarlos*/
    public function cargarSucursal()
    {
        $sql = 'SELECT idsucursal, nombre, telefono, correo
            FROM sucursales
            ORDER BY nombre';
        return Database::getRows($sql);
    }

     /*Funcion para cargar un unico registro*/
     public function readOne()
     {
         $sql = 'SELECT idbodega, numerobodega, direccion
             FROM bodegas
             WHERE idbodega = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
     
      /*Funcion para la actualizacion de un registro*/
    public function updateRow()
    {
        $sql = 'UPDATE bodegas
            SET  numerobodega = ?, direccion = ?, idsucursal = ?
            WHERE idbodega = ?';
        $params = array($this->numerobodega, $this->direccion, $this->sucursal, $this->id);
        return Database::executeRow($sql, $params);
    } 

    /*Funcion para eliminar un registro de la base de datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM bodegas
            WHERE idbodega = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}