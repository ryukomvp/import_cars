<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class TiposUsuariosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*Método para la realizacion de busqueda de registros en la base de datos mediante el nombre de la bodega*/
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idtipousuario, nombretipous,marcas,paisesdeorigen,monedas,familias,categorias,codigoscomunes,tiposproductos,codigostransacciones,codigosplazos,sucursales,plazos,contactos,parametros,proveedores,modelos,empleados,clientes,usuarios,cajas,cajeros,vendedores,bodegas,familiasbodegas,productos,encabezadostransacciones,detallestransacciones,tiposusuarios,bitacoras, inventarios
                FROM tiposusuarios
                WHERE nombretipous LIKE ?
                ORDER BY nombretipous';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    /*Método para la insercion de datos en la base de datos*/
    // public function crearRegistro()
    // {
    //     $sql = 'INSERT INTO tiposusuarios(nombretipous,marcas,paisesdeorigen,monedas,familias,categorias,codigoscomunes,tiposproductos,codigostransacciones,codigosplazos,sucursales,plazos,contactos,parametros,proveedores,modelos,empleados,clientes,usuarios,cajas,cajeros,vendedores,bodegas,familiasbodegas,productos,encabezadostransacciones,detallestransacciones,tiposusuarios)
    //             VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    //     $params = array($this->nombretipous, $this->marcas, $this->paisesdeorigen, $this->monedas, $this->familias, $this->categorias, $this->codigoscomunes, $this->tiposproductos, $this->codigostransacciones, $this->codigosplazos, $this->sucursales, $this->plazos, $this->contactos, $this->parametros, $this->proveedores, $this->modelos, $this->empleados, $this->clientes, $this->usuarios, $this->cajas, $this->cajeros, $this->vendedores, $this->bodegas, $this->familiasbodegas, $this->productos, $this->encabezadostransacciones, $this->detallestransacciones, $this->tiposusuarios);
    //     return Database::executeRow($sql, $params);
    // }

    /*Funcion para cargar los registros en la tabla y mostrarlos*/
    public function leerRegistros()
    {
        $sql = 'SELECT idtipousuario,nombretipous,marcas,paisesdeorigen,monedas,familias,categorias,codigoscomunes,tiposproductos,codigostransacciones,codigosplazos,sucursales,plazos,contactos,parametros,proveedores,modelos,empleados,clientes,usuarios,cajas,cajeros,vendedores,bodegas,familiasbodegas,productos,encabezadostransacciones,detallestransacciones,tiposusuarios,bitacoras
                FROM tiposusuarios
                ORDER BY nombretipous';
        return Database::getRows($sql);
    }

    /*Funcion para cargar un unico registro*/
    public function leerUnRegistro()
    {
        $sql = 'SELECT idtipousuario,nombretipous,marcas,paisesdeorigen,monedas,familias,categorias,codigoscomunes,tiposproductos,codigostransacciones,codigosplazos,sucursales,plazos,contactos,parametros,proveedores,modelos,empleados,clientes,usuarios,cajas,cajeros,vendedores,bodegas,familiasbodegas,productos,encabezadostransacciones,detallestransacciones,tiposusuarios,bitacoras,inventarios
                FROM tiposusuarios
				WHERE idtipousuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /*Funcion para la actualizacion de un registro*/
    public function actualizarRegistro()
    {
        $sql = 'UPDATE tiposusuarios 
                SET nombretipous = ?, marcas = ?, paisesdeorigen = ?, monedas = ?, familias = ?, categorias = ?, codigoscomunes = ?, tiposproductos = ?, codigostransacciones = ?, codigosplazos = ?, sucursales = ?, plazos = ?, contactos = ?, parametros = ?, proveedores = ?, modelos = ?, empleados = ?, clientes = ?, usuarios = ?, cajas = ?, cajeros = ?, vendedores = ?, bodegas = ?, familiasbodegas = ?, productos = ?, encabezadostransacciones = ?, detallestransacciones = ?, tiposusuarios = ?, bitacoras = ?, inventarios = ?
                WHERE idtipousuario = ?';
        $params = array($this->nombretipous, $this->marcas, $this->paisesdeorigen, $this->monedas, $this->familias, $this->categorias, $this->codigoscomunes, $this->tiposproductos, $this->codigostransacciones, $this->codigosplazos, $this->sucursales, $this->plazos, $this->contactos, $this->parametros, $this->proveedores, $this->modelos, $this->empleados, $this->clientes, $this->usuarios, $this->cajas, $this->cajeros, $this->vendedores, $this->bodegas, $this->familiasbodegas, $this->productos, $this->encabezadostransacciones, $this->detallestransacciones, $this->tiposusuarios, $this->bitacoras, $this->inventarios, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*Funcion para eliminar un registro de la base de datos*/
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM tiposusuarios
                WHERE tiposusuarios = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
