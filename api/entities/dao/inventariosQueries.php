<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class InventarioQueries
{
    public function buscarRegistros($value)
    {
        $sql = 'SELECT e.idproducto, e.nombreprod, p.idsucursal, p.cantidad, d.idbodega, d.cantidad
                FROM productos e
                INNER JOIN inventariossucursales p
                ON e.idproducto = p.idproducto
                INNER JOIN inventariosbodegas d
                ON e.idproducto = d.idproducto
                WHERE e.nombreprod = ?
                ORDER BY e.nombreprod';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT e.idproducto, e.nombreprod, p.idsucursal, p.cantidad, d.idbodega, d.cantidad
                FROM productos e
                INNER JOIN inventariossucursales p
                ON e.idproducto = p.idproducto
                INNER JOIN inventariosbodegas d
                ON e.idproducto = d.idproducto
                ORDER BY e.nombreprod';
        return Database::getRows($sql);
    }
}