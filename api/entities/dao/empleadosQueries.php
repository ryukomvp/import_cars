<?php
require_once('../../helpers/database.php');

class empleadosQueries
{

    //funcion para leer los empleados
    public function leerEmpleados()
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, tipodocumento, documento, estadoempleado, genero, cargo
                FROM empleados INNER JOIN cargos USING(idcargo)
                ORDER BY nombre';
        return Database::getRows($sql);
    }

    //funcion para buscar empleados
    public function buscarEmpleado($value)
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, tipodocumento, documento, estadoempleado, genero, cargo
                FROM empleados INNER JOIN cargos USING(idcargo)
                WHERE nombre ILIKE ? OR telefono ILIKE ? OR correo ILIKE ?  OR documento ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //funcion para crear empleados
    public function crearEmpleado()
    {
        $sql = 'INSERT INTO empleados(nombre, telefono, correo, nacimiento, tipodocumento, documento, estadoempleado, genero, idcargo)
                VALUES(?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->nacimiento, $this->tipodocumento, $this->documento, $this->estadoempleado, $this->genero, $this->idcargo);
        return Database::executeRow($sql, $params);
    }

    //funcion para seleccionar un empleado
    public function leerUnEmpleado()
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, tipodocumento, documento, estadoempleado, genero, idcargo
                FROM empleados
                WHERE idempleado = ?';
        $params = array($this->idempleado);
        return Database::getRow($sql, $params);
    }

    //funcion para actualizar empleado
    public function actualizarEmpleado()
    {
        $sql = 'UPDATE empleados
                SET nombre = ?, telefono = ?, correo = ?, nacimiento = ?, tipodocumento = ?, documento = ?, estadoempleado = ?, genero = ?, idcargo = ?
                WHERE idempleado = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->nacimiento, $this->tipodocumento, $this->documento, $this->estadoempleado, $this->genero, $this->idcargo, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    //funcion para eliminar empleado
    public function eliminarEmpleado()
    {
        $sql = 'DELETE FROM empleados
                WHERE idempleado = ?';
        $params = array($this->idempleado);
        return Database::executeRow($sql, $params);
    }

}