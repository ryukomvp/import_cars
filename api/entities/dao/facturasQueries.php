<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class FacturasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function buscarRegistros($value)
    {
        $sql = 'SELECT creditosfiscales.giro, CONCAT(sucursales.nombresuc, " ", sucursales.direccionsuc) nombresucdireccion, facturas.nofactura, facturas.gmail, clientes.nombre, clientes.dui, empleados.nombreemp, cajas.nombrecaja, cajeros.nombrecaja, detallestransacciones.cantidad, productos.nombreprod, producto.descripcionprod, detallestransacciones.preciounitario, detallestransacciones.ventasnosujetas, detallestransaccion.ventasexentas, detallestransacciones.ventasafectas, detallestransacicones.descuento, encabezadostransacciones.suma, encabezadostransacciones.subtotal, encabezadostransacciones.ventatotal
                FROM facturas 
                INNER JOIN creditosfiscales ON facturas.idcreditofiscal = creditosfiscales.idcreditofiscal
                INNER JOIN encabezadostransacciones ON facturas.idencabezadotransaccion = encabezadostransacciones.idencabezadotransaccion
                INNER JOIN inventariossucursales ON encabezadostransacciones.idinventariosucursalsalida = inventariossucursales.idinventariosucursal 
                INNER JOIN sucursales ON inventariossucursales.idsucursal = sucursales.idsucursal
                INNER JOIN creditosfiscales ON facturas.idcreditofiscal = creditosfiscales.idcreditofiscal
                INNER JOIN clientes ON facturas.idcliente = clientes.idcliente
                INNER JOIN vendedores ON encabezadostransacciones.idvendedor = vendedores.idvendedor
                INNER JOIN usuarios ON vendedores.idusuario = usuarios.idusuario
                INNER JOIN empleados ON usuarios.idempleado = empleados.idempleado
                INNER JOIN cajeros ON encabezadostransacciones.idcajero = cajeros.idcajero
                INNER JOIN cajas ON cajeros.idcaja = cajas.idcaja
                INNER JOIN inventariosbodegas ON encabezadostransacciones.idinventariobodegasalida = inventariosbodegas.idinventariobodega
                INNER JOIN productos ON inventariosbodegas.idproducto = productos.idproducto
                WHERE entradas.descripcion LIKE ? OR productos.nombre LIKE ? empleados.nombre LIKE ? 
                ORDER BY facturas.nofactura';
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
        $sql = 'SELECT creditosfiscales.giro, CONCAT(sucursales.nombresuc, " ", sucursales.direccionsuc) nombresucdireccion, facturas.nofactura, facturas.gmail, clientes.nombre, clientes.dui, empleados.nombreemp, cajas.nombrecaja, cajeros.nombrecaja, detallestransacciones.cantidad, productos.nombreprod, producto.descripcionprod, detallestransacciones.preciounitario, detallestransacciones.ventasnosujetas, detallestransaccion.ventasexentas, detallestransacciones.ventasafectas, detallestransacicones.descuento, encabezadostransacciones.suma, encabezadostransacciones.subtotal, encabezadostransacciones.ventatotal
        FROM facturas 
        INNER JOIN creditosfiscales ON facturas.idcreditofiscal = creditosfiscales.idcreditofiscal
        INNER JOIN encabezadostransacciones ON facturas.idencabezadotransaccion = encabezadostransacciones.idencabezadotransaccion
        INNER JOIN inventariossucursales ON encabezadostransacciones.idinventariosucursalsalida = inventariossucursales.idinventariosucursal 
        INNER JOIN sucursales ON inventariossucursales.idsucursal = sucursales.idsucursal
        INNER JOIN creditosfiscales ON facturas.idcreditofiscal = creditosfiscales.idcreditofiscal
        INNER JOIN clientes ON facturas.idcliente = clientes.idcliente
        INNER JOIN vendedores ON encabezadostransacciones.idvendedor = vendedores.idvendedor
        INNER JOIN usuarios ON vendedores.idusuario = usuarios.idusuario
        INNER JOIN empleados ON usuarios.idempleado = empleados.idempleado
        INNER JOIN cajeros ON encabezadostransacciones.idcajero = cajeros.idcajero
        INNER JOIN cajas ON cajeros.idcaja = cajas.idcaja
        INNER JOIN inventariosbodegas ON encabezadostransacciones.idinventariobodegasalida = inventariosbodegas.idinventariobodega
        INNER JOIN productos ON inventariosbodegas.idproducto = productos.idproducto
        ORDER BY facturas.nofactura';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT creditosfiscales.giro, CONCAT(sucursales.nombresuc, " ", sucursales.direccionsuc) nombresucdireccion, facturas.nofactura, facturas.gmail, clientes.nombre, clientes.dui, empleados.nombreemp, cajas.nombrecaja, cajeros.nombrecajero, detallestransacciones.cantidad, productos.nombreprod, productos.descripcionprod, detallestransacciones.preciounitario, detallestransacciones.ventasnosujetas, detallestransacciones.ventasexentas, detallestransacciones.ventasafectas, detallestransacciones.descuento, encabezadostransacciones.suma, encabezadostransacciones.subtotal, encabezadostransacciones.ventatotal
        FROM facturas 
        INNER JOIN creditosfiscales ON facturas.idcreditofiscal = creditosfiscales.idcreditofiscal
        INNER JOIN encabezadostransacciones ON facturas.idencabezadotransaccion = encabezadostransacciones.idencabezadotransaccion
        INNER JOIN detallestransacciones ON detallestransacciones.idencabezadotransaccion = encabezadostransacciones.idencabezadotransaccion
        INNER JOIN inventariossucursales ON encabezadostransacciones.idinventariosucursalsalida = inventariossucursales.idinventariosucursal 
        INNER JOIN sucursales ON inventariossucursales.idsucursal = sucursales.idsucursal
        INNER JOIN clientes ON facturas.idcliente = clientes.idcliente
        INNER JOIN vendedores ON encabezadostransacciones.idvendedor = vendedores.idvendedor
        INNER JOIN usuarios ON vendedores.idusuario = usuarios.idusuario
        INNER JOIN empleados ON usuarios.idempleado = empleados.idempleado
        INNER JOIN cajeros ON encabezadostransacciones.idcajero = cajeros.idcajero
        INNER JOIN cajas ON cajeros.idcaja = cajas.idcaja
        INNER JOIN inventariosbodegas ON encabezadostransacciones.idinventariobodegasalida = inventariosbodegas.idinventariobodega
        INNER JOIN productos ON inventariosbodegas.idproducto = productos.idproducto
            WHERE facturas.idfactura = 1';
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
