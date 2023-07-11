<?php
require_once('../helpers/database.php');

class empleadosQueries
{

    //funcion para leer los empleados
    public function leerEmpleados()
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, documento, estadoempleado, genero, cargo
        FROM empleados
        ORDER BY nombre';
        return Database::getRows($sql);
    }

    //funcion para buscar empleados
    public function buscarEmpleado($value)
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, documento, estadoempleado, genero, cargo
                FROM empleados
                WHERE nombre ILIKE ? OR telefono ILIKE ? OR correo ILIKE ?  OR documento ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //funcion para crear empleados
    public function crearEmpleado()
    {
        $sql = 'INSERT INTO empleados(nombre, telefono, correo, nacimiento, documento, estadoempleado, genero, cargo)
                VALUES(?,?,?,?,?,?,?,?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->nacimiento, $this->documento, $this->estado, $this->genero, $this->cargo);
        return Database::executeRow($sql, $params);
    }

    //funcion para seleccionar un empleado
    public function leerUnEmpleado()
    {
        $sql = 'SELECT idempleado, nombre, telefono, correo, nacimiento, documento, estadoempleado, genero, cargo
                FROM empleados
                WHERE idempleado = ?';
        $params = array($this->idempleado);
        return Database::getRow($sql, $params);
    }

    //funcion para leer los estados de empleado
    public function leerEstadosEmpleados()
    {
        $sql = 'SELECT unnest(enum_range(NULL::estadosempleados)) val, unnest(enum_range(NULL::estadosempleados)) text';
        return Database::getRows($sql);
    }

    //funcion para leer los generos
    public function leerGeneros()
    {
        $sql = 'SELECT unnest(enum_range(NULL::generos)) val, unnest(enum_range(NULL::generos)) text';
        return Database::getRows($sql);
    }

    public function leerCargos()
    {
        $sql = 'SELECT unnest(enum_range(NULL::cargos)) val, unnest(enum_range(NULL::cargos)) text';
        return Database::getRows($sql);
    }

    //funcion para actualizar empleado
    public function actualizarEmpleado()
    {
        $sql = 'UPDATE empleados
                SET nombre = ?, telefono = ?, correo = ?, nacimiento = ?, documento = ?, estadoempleado = ?, genero = ?, cargo = ?
                WHERE idempleado = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->nacimiento, $this->documento, $this->estado, $this->genero, $this->cargo, $this->idempleado);
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