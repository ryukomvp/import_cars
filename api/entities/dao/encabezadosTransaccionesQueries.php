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
        $sql = 'SELECT e.correlativo, e.fechahora, e.tipodepago ,e.lote, e.npoliza, c.nombre, c.correo, t.nombrecodigo, s.nombresuc, v.nombreemp
                FROM encabezadotransacciones e
                INNER JOIN clientes c ON e.idcliente = c.idcliente
                INNER JOIN codigostransacciones t ON e.idcodigotransaccion = t.idcodigotransaccion
                INNER JOIN inventariossucursales s ON e.idinventariosucursal = s.idinventariosucursal
                INNER JOIN sucursales n ON s.idsucursal = s.idsucursal
                INNER JOIN vendedores v ON e.idvendedor = v.idvendedor
                INNER JOIN usuarios u ON v.idusuraio = u.idusuario
                INNER JOIN empleados p ON u.idempleado = p.idempleado
                WHERE e.correlativo LIKE ? OR e.lote LIKE ? OR e.npoliza LIKE ? OR c.nombre LIKE ? OR t.nombrecodigo OR s.nombresuc OR v.nombreemp
                ORDER BY e.correlativo;';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO encabezadostransacciones(nocomprobante, fechatransac, lote, npoliza, idbodega, idcajero, tipopago, idcodigotransaccion, idcliente, idvendedor, idproveedor, idparametro, iddetalletransaccion)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nocomprobante, $this->fechatransac, $this->lote, $this->npoliza, $this->idbodega, $this->idcajero, $this->tipopago, $this->idcodigotransaccion, $this->idcliente, $this->idvendedor, $this->idproveedor, $this->idparametro, $this->iddetallestransaccion);
        return Database::executeRow($sql, $params);
    }


    SELECT e.correlativo, e.fechahora, e.tipodepago ,e.lote, e.npoliza, c.nombre, c.correo, t.nombrecodigo, s.nombresuc, v.nombreemp
FROM encabezadotransacciones e
INNER JOIN clientes c ON e.idcliente = c.idcliente
INNER JOIN codigostransacciones t ON e.idcodigotransaccion = t.idcodigotransaccion
INNER JOIN inventariossucursales s ON e.idinventariosucursal = s.idinventariosucursal
INNER JOIN sucursales n ON s.idsucursal = s.idsucursal
INNER JOIN vendedores v ON e.idvendedor = v.idvendedor
INNER JOIN usuarios u ON v.idusuraio = u.idusuario
INNER JOIN empleados p ON u.idempleado = p.idempleado
WHERE e.correlativo LIKE ? OR e.lote LIKE ? OR e.npoliza LIKE ? OR c.nombre LIKE ? OR t.nombrecodigo OR s.nombresuc OR v.nombreemp
ORDER BY e.correlativo;

INSERT INTO encabezadotransacciones (correlatico, fechatransac, lote, npoliza, tipopago, idcodigotransaccion, idcliente, )
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

    public function leerRegistros()
    {
        $sql = 'SELECT a.idencatransaccion, a.nocomprobante, a.fechatransac, a.lote, a.npoliza, b.numerobod, c.nombrecajero, a.tipopago, CONCAT(d.codigo, " ", d.nombrecodigo) codigo, l.nombre, u.nombreus, v.nombreprov, o.nombreemp, j.correlativo
                FROM encabezadostransacciones a 
                INNER JOIN bodegas b ON a.idbodega = b.idbodega
                INNER JOIN cajeros c ON a.idcajero = c.idcajero
                INNER JOIN codigostransacciones d ON a.idcodigotransaccion = d.idcodigotransaccion
                INNER JOIN clientes l ON a.idcliente = l.idcliente
                INNER JOIN vendedores s ON a.idvendedor = s.idvendedor
                INNER JOIN usuarios u ON s.idusuario = u.idusuario
                INNER JOIN proveedores v ON a.idproveedor = v.idproveedor
                INNER JOIN parametros o ON a.idparametro = o.idparametro
                INNER JOIN detallestransacciones j ON a.iddetalletransaccion = j.iddetalletransaccion
                ORDER BY a.nocomprobante';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idencatransaccion, nocomprobante, fechatransac, lote, npoliza, idbodega, idcajero, tipopago, idcodigotransaccion, idcliente, idvendedor, idproveedor, idparametro, iddetalletransaccion
                FROM encabezadostransacciones
                WHERE idencatransaccion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE encabezadostransacciones
                SET nocomprobante = ?, fechatransac = ?, lote = ?, npoliza = ?, idbodega = ?, idcajero = ?, tipopago = ?, idcodigotransaccion = ?, idcliente = ?, idvendedor = ?, idproveedor = ?, idparametro = ?, iddetalletransaccion = ?
                WHERE idencatransaccion = ?';
        $params = array($this->nocomprobante, $this->fechatransac, $this->lote, $this->npoliza, $this->idbodega, $this->idcajero, $this->tipopago, $this->idcodigotransaccion, $this->idcliente, $this->idvendedor, $this->idproveedor, $this->idparametro, $this->iddetalletransaccion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM encabezadostransacciones
                WHERE idencatransaccion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerTiposPagos()
    {
        $estados = array(array('Efectivo','Efectivo'), array('Tarjeta','Tarjeta'));
        return $estados;
    }
}
