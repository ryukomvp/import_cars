<?php
require_once('../helpers/database.php');
/*
*  Clase para manejar el acceso a datos de la entidad de FAMILIAS BODEGAS
*/
class FamiliasBodegasQueries
{
    /*
    *   Métodos para generar gráficas por la cantidad de familias existentes en una bodega.
    */
    public function cantidadFamiliaBodega()
    {
        $sql = 'SELECT direccionbod AS "bodegas", COUNT(idfamilia) AS "cantidad"
        FROM familiasbodegas INNER JOIN bodegas USING(idbodega)
        INNER JOIN familias USING(idfamilia)
        GROUP BY direccionbod
        ORDER BY cantidad DESC
        LIMIT 5';
        return Database::getRows($sql);
    }
}