<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class BitacoraQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idbitacora, mensaje, fechabitacora
                FROM bitacoras
                WHERE mensaje LIKE ?
                ORDER BY fechabitacora';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idbitacora, mensaje, fechabitacora
                FROM bitacoras
                ORDER BY mensaje';
        return Database::getRows($sql);
    }
}
