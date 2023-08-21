<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad DETALLES TRANSACCION.
*/
class DetallesTransaccionQueries
{
    /*
    *   Métodos para generar gráficas la cantidad de productos en una transaccion.
    */
    public function cantidadCantidadTransaccion()
    {
        $sql = 'SELECT iddetalletransaccion AS "detalle", cantidad
        FROM detallestransacciones INNER JOIN encabezadostransacciones USING(idencatransaccion)
        INNER JOIN familias USING(idfamilia)
        GROUP BY iddetalletransaccion
        ORDER BY cantidad DESC
        LIMIT 5';
        return Database::getRows($sql);
    }   
}