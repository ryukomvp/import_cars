<?php
require_once('../helpers/database.php');
/*
*  Clase para manejar el acceso a datos de la entidad de FAMILIAS
*/
class FamiliasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos
     mediante el nombre de la bodega*/
     public function buscarRegistros($value)
     {
         $sql = 'SELECT idfamilia, familia
             FROM familias
             WHERE familia ILIKE ?
             ORDER BY familia';
         $params = array("%$value%");
         return Database::getRows($sql, $params);    
     }

     /*Método para la insercion de datos en la base de datos*/
    public function crearRegistro()
    {
        $sql = 'INSERT INTO familias(familia)
            VALUES(?)';
        $params = array($this->familia);
        return Database::executeRow($sql, $params);
    }
    
    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function leerRegistros()
    {
        $sql = 'SELECT idfamilia, familia
            FROM familias
            ORDER BY familia';
        return Database::getRows($sql);
    }

     /*Funcion para cargar un unico registro*/
     public function leerUnRegistro()
     {
         $sql = 'SELECT idfamilia, familia
             FROM familias
             WHERE idfamilia = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
     
      /*Funcion para la actualizacion de un registro*/
    public function actualizarRegistro()
    {
        $sql = 'UPDATE familias
            SET  familia = ?
            WHERE idfamilia = ?';
        $params = array($this->familia, $this->id);
        return Database::executeRow($sql, $params);
    } 

    /*Funcion para eliminar un registro de la base de datos*/
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM familias
            WHERE idfamilia = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}