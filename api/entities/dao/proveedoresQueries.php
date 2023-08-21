<?php
require_once('../helpers/database.php');

class proveedoresQueries
{
    // Función para leer los países de origen
    public function leerProveedores()
    {
        $sql = 'SELECT idproveedor, nombreprov, telefonoprov, correoprov, codigoprov, codigomaestroprov, duiprov, moneda, numeroregistroprov 
                FROM proveedores INNER JOIN monedas USING(idmoneda)
                ORDER BY nombreprov';
        return Database::getRows($sql);
    }
    // Funcion para buscar paises de origen
    public function buscarProveedor($value)
    {
        $sql = 'SELECT idproveedor, nombreprov, telefonoprov, correoprov, codigoprov, codigomaestroprov, duiprov, moneda, numeroregistroprov
                FROM proveedores INNER JOIN monedas USING(idmoneda)
                WHERE nombreprov LIKE ? OR telefonoprov LIKE ? OR correoprov LIKE ?  OR duiprov LIKE ? OR codigoprov LIKE ? OR codigomaestroprov LIKE ?
                ORDER BY nombreprov';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearProveedor()
    {
        $sql = 'INSERT INTO proveedores(nombreprov, telefonoprov, correoprov,  codigoprov, codigomaestroprov, duiprov, idmoneda, numeroregistroprov)
                VALUES(?,?,?,?,?,?,?,?)';
        $params = array($this->nombreprov, $this->telefonoprov, $this->correoprov, $this->codigoprov, $this->codigomaestroprov, $this->duiprov, $this->idmoneda, $this->numeroregistroprov);
        return Database::executeRow($sql, $params);
    }
    // Función para seleccionar un pais de origen
    public function leerUnProveedor()
    {
        $sql = 'SELECT idproveedor, nombreprov, telefonoprov, correoprov, codigoprov, codigomaestroprov, duiprov, idmoneda, numeroregistroprov
                FROM proveedores
                WHERE idproveedor = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarProveedor()
    {
        $sql = 'UPDATE proveedores
                SET nombreprov = ?, telefonoprov = ?, correoprov = ?, codigoprov = ?, codigomaestroprov = ?, duiprov = ?, idmoneda = ?, numeroregistroprov = ?
                WHERE idproveedor = ?';
        $params = array($this->nombreprov, $this->telefonoprov, $this->correoprov, $this->codigoprov, $this->codigomaestroprov, $this->duiprov, $this->idmoneda, $this->numeroregistroprov, $this->id);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarProveedor()
    {
        $sql = 'DELETE FROM proveedores
                WHERE idproveedor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Funcion para generar grafica parametrizada
    public function graficaCantidadTransaccionesProveedor()
    {
        $sql = 'SELECT proveedores.nombreprov, COUNT(encabezadostransacciones.idencatransaccion) AS cantidad_transacciones 
                FROM proveedores
                INNER JOIN encabezadostransacciones ON proveedores.idproveedor = encabezadostransacciones.idproveedor
                WHERE proveedores.idproveedor = ?
                GROUP BY proveedores.nombreprov';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
