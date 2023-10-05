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
        FROM detallestransacciones 
        GROUP BY iddetalletransaccion
        ORDER BY cantidad DESC
        LIMIT 5';
        return Database::getRows($sql);
    }  
    
    public function buscarRegistros($value)
    {
        $sql = 'SELECT a.iddetalletransaccion, a.correlativo, a.cantidad, a.preciounitario, a.ventanosujeta, a.ventaexenta, a.ventaafecta, a.descuento, a.valordescuento, a.sumas, a.subtotal, a.ventatotal, a.iva, a.observaciones, b.numerobod as bodegaEntrada, e.numerobod as bodegaSalida, c.nombreprod, a.descripcion, d.nocomprobante 
        FROM detallestransacciones a 
        INNER JOIN bodegas b ON a.idbodegaentrada = b.idbodega 
        INNER JOIN bodegas e ON a.idbodegasalida = e.idbodega 
        INNER JOIN productos c ON a.idproducto = c.idproducto 
        INNER JOIN encabezadostransacciones d ON a.idencatransaccion = d.idencatransaccion 
        ORDER BY a.correlativo';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO detallestransacciones(correlativo, cantidad, preciounitario, ventanosujeta, ventaexenta, ventaafecta, descuento, valordescuento, sumas, subtotal, ventatotal, iva, observaciones, idbodegaentrada, idbodegasalida, idproducto, descripcion, idencatransaccion)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->correlativo, $this->cantidad, $this->preciounitario, $this->ventanosujeta, $this->ventaexenta, $this->ventaafecta, $this->descuento, $this->valordescuento, $this->sumas, $this->subtotal, $this->ventatotal, $this->iva, $this->observaciones, $this->idbodegaentrada, $this->idbodegasalida, $this->idproducto, $this->descripcion, $this->idencatransaccion);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT a.iddetalletransaccion, f.fechatransac , a.correlativo, a.cantidad, a.preciounitario, a.ventanosujeta, a.ventaexenta, a.ventaafecta, a.descuento, a.valordescuento, a.sumas, CONCAT(d.codigo, " ", d.nombrecodigo) codigo, a.subtotal, a.ventatotal, a.iva, a.observaciones, b.numerobod as bodegaEntrada, e.numerobod as bodegaSalida, c.nombreprod, a.descripcion, f.nocomprobante 
        FROM encabezadostransacciones f  
        INNER JOIN codigostransacciones d ON f.idcodigotransaccion = d.idcodigotransaccion
        INNER JOIN detallestransacciones a ON a.iddetalletransaccion = f.iddetalletransaccion
        INNER JOIN bodegas b ON a.idbodegaentrada = b.idbodega 
        INNER JOIN bodegas e ON a.idbodegasalida = e.idbodega 
        INNER JOIN productos c ON a.idproducto = c.idproducto  
        WHERE d.codigo = 1235
        ORDER BY a.correlativo';
        return Database::getRows($sql);
    }

    public function leerVentas()
    {
        $sql = 'SELECT a.iddetalletransaccion, f.fechatransac , a.correlativo, a.cantidad, a.preciounitario, a.ventanosujeta, a.ventaexenta, a.ventaafecta, a.descuento, a.valordescuento, a.sumas, CONCAT(d.codigo, " ", d.nombrecodigo) codigo, a.subtotal, a.ventatotal, a.iva, a.observaciones, b.numerobod as bodegaEntrada, e.numerobod as bodegaSalida, c.nombreprod, a.descripcion, f.nocomprobante 
        FROM encabezadostransacciones f  
        INNER JOIN codigostransacciones d ON f.idcodigotransaccion = d.idcodigotransaccion
        INNER JOIN detallestransacciones a ON a.iddetalletransaccion = f.iddetalletransaccion
        INNER JOIN bodegas b ON a.idbodegaentrada = b.idbodega 
        INNER JOIN bodegas e ON a.idbodegasalida = e.idbodega 
        INNER JOIN productos c ON a.idproducto = c.idproducto  
        WHERE d.codigo = 1235
        ORDER BY a.correlativo';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT iddetalletransaccion, correlativo, cantidad, preciounitario, ventanosujeta, ventaexenta, ventaafecta, descuento, valordescuento, sumas, subtotal, ventatotal, iva, observaciones, idbodegaentrada, idbodegasalida, idproducto, descripcion, idencatransaccion
                FROM detallestransacciones
                WHERE iddetalletransaccion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE detallestransacciones
                SET correlativo = ?, cantidad = ?, preciounitario = ?, ventanosujeta = ?, ventaexenta = ?, ventaafecta = ?, descuento = ?, valordescuento = ?, sumas = ?, subtotal = ?, ventatotal = ?, iva = ?, observaciones = ?, idbodegaentrada = ?, idbodegasalida = ?, idproducto = ?, descripcion = ?, idencatransaccion = ?
                WHERE iddetalletransaccion = ?';
        $params = array($this->correlativo, $this->cantidad, $this->preciounitario, $this->ventanosujeta, $this->ventaexenta, $this->ventaafecta, $this->descuento, $this->valordescuento, $this->sumas, $this->subtotal, $this->ventatotal, $this->iva, $this->observaciones, $this->idbodegaentrada, $this->idbodegasalida, $this->idproducto, $this->descripcion, $this->idencatransaccion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM detallestransacciones
                WHERE iddetalletransaccion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerVentasReporte()
    {
        $sql = 'SELECT a.idencatransaccion , a.fechatransac , f.correlativo, f.cantidad, f.preciounitario, f.ventanosujeta, a.lote, f.ventaexenta, f.ventaafecta, f.descuento, f.valordescuento, f.sumas, CONCAT(d.codigo, " ", d.nombrecodigo) codigo, f.subtotal, f.ventatotal, f.iva, f.observaciones, b.numerobod as bodegaEntrada, e.numerobod as bodegaSalida, c.nombreprod, f.descripcion, a.nocomprobante 
        FROM encabezadostransacciones a 
        INNER JOIN detallestransacciones f ON a.iddetalletransaccion = f.iddetalletransaccion
        INNER JOIN bodegas b ON f.idbodegaentrada = b.idbodega 
        INNER JOIN bodegas e ON f.idbodegasalida = e.idbodega 
        INNER JOIN productos c ON f.idproducto = c.idproducto 
        INNER JOIN codigostransacciones d ON a.idcodigotransaccion = d.idcodigotransaccion 
        ORDER BY f.correlativo';
        return Database::getRows($sql);
    }
}