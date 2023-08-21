<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class EncabezadosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function encaBodegas()
    {
        $sql = 'SELECT numerobod, count(idencatransaccion) idencatransaccion
        FROM encabezadostransacciones INNER JOIN bodegas ON encabezadostransacciones.idbodega = bodegas.idbodega
        GROUP BY numerobod ORDER BY idencatransaccion DESC';
        return Database::getRows($sql);
    }
}
