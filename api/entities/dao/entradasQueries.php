<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class entradasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarEntradas($value)
    {
        $sql = 'SELECT identrada, descripcion, idproducto, cantidad, precio, fechaentrada, idempleado
                FROM entradas
                INNER JOIN productos USING(idproducto)
                INNER JOIN empleados USING(idempleado)
                WHERE descripcion LIKE ? OR descripcion LIKE ? OR categoria LIKE ? OR nomenclatura LIKE ? OR codigo LIKE ? 
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearEntradas()
    {
        $sql = 'INSERT INTO entradas(descripcion, idproducto, cantidad, precio, fechaentrada , idTipoProducto, idempleado)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->descripcion, $this->producto, $this->cantidad, $this->precio, $this->fechaEntrada, $this->tipoProducto, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function leerTodo()
    {
        $sql = 'SELECT entradas.descripcion, producto.nombre, entradas.cantidad, entradas.precio, entradas.fechaentrada, empleados.idempleado
                FROM entradas 
                INNER JOIN productos ON entradas.idproducto = productos.idproducto
                INNER JOIN empleados ON entradas.idempleado = empleados.idempleado
                Order by nombre = ?';
        return Database::getRows($sql);
    }

    public function leerUnaEntrada()
    {
        $sql = 'SELECT identrada , descripcion, idproducto, precio, fechaentrada, idempleado
                FROM entradas
                WHERE identrada = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarEntradas($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE entradas
                SET descripcion = ?, idproducto= ?, precio= ?, fechaentrada= ?, idempleado= ? 
                WHERE identrada = ?';
        $params = array($this->descripcion, $this->producto, $this->precio, $this->fecha, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function eliminarProducto()
    {
        $sql = 'DELETE FROM entradas
                WHERE identrada = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
