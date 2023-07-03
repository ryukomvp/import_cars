<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class EntradasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarRegistros($value)
    {
        $sql = 'SELECT entradas.identrada, entradas.descripcion, productos.nombre, entradas.cantidad, entradas.precio, entradas.fechaentrada, empleados.nombre as empleado
                FROM entradas 
                INNER JOIN productos ON entradas.idproducto = productos.idproducto
                INNER JOIN empleados ON entradas.idempleado = empleados.idempleado
                WHERE entradas.descripcion LIKE ? OR productos.nombre LIKE ? empleados.nombre LIKE ? 
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = 'INSERT INTO entradas(descripcion, idproducto, cantidad, precio, fechaentrada ,  idempleado)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->descripcion, $this->producto, $this->cantidad, $this->precio, $date, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT entradas.identrada, entradas.descripcion, productos.nombre, entradas.cantidad, entradas.precio, entradas.fechaentrada, empleados.nombre as empleado
                FROM entradas 
                INNER JOIN productos ON entradas.idproducto = productos.idproducto
                INNER JOIN empleados ON entradas.idempleado = empleados.idempleado
                Order by productos.nombre';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT identrada , descripcion, idproducto, precio, fechaentrada, idempleado
                FROM entradas
                WHERE identrada = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE entradas
                SET descripcion = ?, idproducto= ?, precio= ?, idempleado= ? 
                WHERE identrada = ?';
        $params = array($this->descripcion, $this->producto, $this->precio, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM entradas
                WHERE identrada = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
