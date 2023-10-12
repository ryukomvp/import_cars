<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class ClientesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcliente, nombre, giro, dui, correo, telefono, contacto, descuento, exoneracion, fechaini, tipocliente, plazos.descripcion
        FROM clientes INNER JOIN plazos ON clientes.idplazo = plazos.idplazo 
                WHERE nombre LIKE ? OR dui LIKE ? OR correo LIKE ? OR telefono LIKE ? OR tipocliente LIKE ? OR plazos.tipoplazo LIKE ? 
                ORDER BY nombre';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO clientes(nombre, giro, dui, correo, telefono, contacto, descuento, exoneracion, fechaini, tipocliente, idplazo)
                VALUES(?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre, $this->giro, $this->dui, $this->correo, $this->telefono, $this->contacto, $this->descuento, $this->exoneracion, $this->fechaini, $this->tipocliente, $this->idplazo);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcliente, nombre, giro, dui, correo, telefono, contacto, descuento, exoneracion, fechaini, tipocliente, plazos.descripcion
                FROM clientes INNER JOIN plazos ON clientes.idplazo = plazos.idplazo 
                ORDER BY nombre';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcliente, nombre, giro, dui, correo, telefono, contacto, descuento, exoneracion, fechaini, tipocliente, idplazo
                FROM clientes
                WHERE idcliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE clientes
                SET nombre = ?, giro = ?, dui = ?, correo = ?, telefono = ?, contacto = ?, descuento = ?, exoneracion = ?, fechaini = ?, tipocliente = ?, idplazo = ?
                WHERE idcliente = ?';
        $params = array( $this->nombre, $this->giro, $this->dui, $this->correo, $this->telefono, $this->contacto, $this->descuento, $this->exoneracion, $this->fechaini, $this->tipocliente, $this->idplazo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM clientes
                WHERE idcliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerTiposClientes()
    {
        $estados = array(array('Fiscal','Fiscal'), array('Consumidor Final','Consumidor Final'));
        return $estados;
    }
}
