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

    public function buscarRegistros($value)
    {
        $sql = 'SELECT a.idencatransaccion, a.nocomprobante, a.fechatransac, a.lote, a.npoliza, b.numerobod, c.nombrecajero, a.tipopago, CONCAT(d.codigo, " ", d.nombrecodigo) Codigo, l.nombre, u.nombreus, v.nombreprov, o.registro
                FROM encabezadostransacciones a 
                INNER JOIN bodegas b ON a.idbodega = b.idbodega
                INNER JOIN cajeros c ON a.idcajero = c.idcajero
                INNER JOIN codigostransacciones d ON a.idcodigotransaccion = d.idcodigotransaccion
                INNER JOIN clientes l ON a.idcliente = l.idcliente
                INNER JOIN vendedores s ON a.idvendedor = s.idvendedor
                INNER JOIN usuarios u ON s.idusuario = u.idusuario
                INNER JOIN proveedores v ON a.idproveedor = v.idproveedor
                INNER JOIN parametros o ON a.idparametro = o.idparametro
                WHERE b.numerobod LIKE ? OR c.nombrecajero LIKE ? OR p.tipopago LIKE ? OR d.codigo LIKE ? OR d.nombrecodigo LIKE ? OR l.nombre LIKE ? OR u.nombreus LIKE ? OR v.nombreprov LIKE ? OR o.registro LIKE ? 
                ORDER BY a.nocomprobante';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO encabezadostransacciones(nocomprobante, fechtransac, lote, npoliza, idbodega, idcajero, tipopago, idcodigotransaccion, idcliente, idvendedor, idproveedor, idparametro)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nocomprobante, $this->fechatransac, $this->lote, $this->npoliza, $this->idbodega, $this->idcajero, $this->tipopago, $this->idcodigotransaccion, $this->idcliente, $this->idvendedor, $this->idproveedor, $this->idparametro);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT a.idencatransaccion, a.nocomprobante, a.fechatransac, a.lote, a.npoliza, b.numerobod, c.nombrecajero, a.tipopago, CONCAT(d.codigo, " ", d.nombrecodigo) codigo, l.nombre, u.nombreus, v.nombreprov, o.registro
                FROM encabezadostransacciones a 
                INNER JOIN bodegas b ON a.idbodega = b.idbodega
                INNER JOIN cajeros c ON a.idcajero = c.idcajero
                INNER JOIN codigostransacciones d ON a.idcodigotransaccion = d.idcodigotransaccion
                INNER JOIN clientes l ON a.idcliente = l.idcliente
                INNER JOIN vendedores s ON a.idvendedor = s.idvendedor
                INNER JOIN usuarios u ON s.idusuario = u.idusuario
                INNER JOIN proveedores v ON a.idproveedor = v.idproveedor
                INNER JOIN parametros o ON a.idparametro = o.idparametro
                ORDER BY a.nocomprobante';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idencatransaccion, nocomprobante, fechatransac, lote, npoliza, idbodega, idcajero, tipopago, idcodigotransaccion, idcliente, idvendedor, idproveedor, idparametro
                FROM encabezadostransacciones
                WHERE idencatransaccion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE encabezadostransacciones
                SET nocmprobante = ?, fechatransac = ?, lote = ?, npoliza = ?, idbodega = ?, idcajero = ?, tipopago = ?, idcodigotransaccion = ?, idcliente = ?, idvendedor = ?, idproveedor = ?, idparametro = ?
                WHERE idencatransaccion = ?';
        $params = array($this->nocomprobante, $this->fechatransac, $this->lote, $this->npoliza, $this->idbodega, $this->idcajero, $this->tipopago, $this->idcodigotransaccion, $this->idcliente, $this->idvendedor, $this->idproveedor, $this->idparametro, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM encabezadostransacciones
                WHERE idencatransaccion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function encaBodegas()
    {
        $sql = 'SELECT numerobod, count(idencatransaccion) idencatransaccion
        FROM encabezadostransacciones INNER JOIN bodegas ON encabezadostransacciones.idbodega = bodegas.idbodega
        GROUP BY numerobod ORDER BY idencatransaccion DESC';
        return Database::getRows($sql);
    }
}
