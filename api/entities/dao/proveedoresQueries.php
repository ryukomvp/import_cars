<?php
require_once('../helpers/database.php');

class proveedoresQueries
{
    // Función para leer los países de origen
    public function leerProveedores()
    {
        $sql = 'SELECT idproveedor, nombre, telefono, correo, fechacompra, saldoinicial, saldoactual, codigoprov, codigomaestroprov, dui, moneda, numeroregistroprov 
                FROM proveedores INNER JOIN monedas USING(idmoneda)
                ORDER BY nombre';
        return Database::getRows($sql);
    }
    // Funcion para buscar paises de origen
    public function buscarProveedor($value)
    {
        $sql = 'SELECT idproveedor, nombre, telefono, correo, fechacompra, saldoinicial, saldoactual, codigoprov, codigomaestroprov, dui, moneda, numeroregistroprov
                FROM proveedores INNER JOIN monedas USING(idmoneda)
                WHERE nombre ILIKE ? OR telefono ILIKE ? OR telefono ILIKE ? or correo ILIKE ? OR codigoprov LILIKE ? OR codigomaestroprov ILIKE ? OR dui ILIKE ? OR numeroregistroprov ILIKE ?
                ORDER BY pais';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearProveedor()
    {
        $sql = 'INSERT INTO proveedores(nombre, telefono, correo, fechacompra, saldoinicial, saldoactual, codigoprov, codigomaestroprov, dui, idmoneda, numeroregistroprov)
                VALUES(?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->fechacompra, $this->saldoinicial, $this->saldoactual, $this->codigoprov, $this->codigomaestroprov, $this->dui, $this->idmoneda, $this->numeroregistroprov);
        return Database::executeRow($sql, $params);
    }
    // Función para seleccionar un pais de origen
    public function leerunProveedor()
    {
        $sql = 'SELECT idproveedor, nombre, telefono, correo, fechacompra, saldoinicial, saldoactual, codigoprov, codigomaestroprov, dui, idmoneda, numeroregistroprov
                FROM proveedores
                WHERE idproveedor = ?';
        $params = array($this->idproveedor);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarProveedor()
    {
        $sql = 'UPDATE proveedores
                SET nombre = ?, telefono = ?, correo = ?, fechacompra = ?, saldoinicial = ?, saldoactual = ?, codigoprov = ?, codigomaestroprov = ?, dui = ?, idmoneda = ?, numeroregistroprov = ?
                WHERE idproveedor = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->fechacompra, $this->saldoinicial, $this->saldoactual, $this->codigoprov, $this->codigomaestroprov, $this->dui, $this->idmoneda, $this->numeroregistroprov, $this->idproveedor);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarProveedor()
    {
        $sql = 'DELETE FROM proveedores
                WHERE idproveedor = ?';
        $params = array($this->idproveedor);
        return Database::executeRow($sql, $params);
    }
}
