<?php
require_once('../helpers/database.php');

class empleadosQueries
{

    //funcion para leer los empleados
    public function leerEmpleados()
    {
        $sql = 'SELECT idempleado, nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo
        FROM empleados
        ORDER BY nombreemp';
        return Database::getRows($sql);
    }

    //funcion para buscar empleados
    public function buscarEmpleado($value)
    {
        $sql = 'SELECT idempleado, nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo
                FROM empleados
                WHERE nombre LIKE ? OR telefono LIKE ? OR correo LIKE ?  OR documento LIKE ?
                ORDER BY nombreemp';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //funcion para crear empleados
    public function crearEmpleado()
    {
        $sql = 'INSERT INTO empleados(nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo)
                VALUES(?,?,?,?,?,?,?,?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->nacimiento, $this->documento, $this->estado, $this->genero, $this->cargo);
        return Database::executeRow($sql, $params);
    }

    //funcion para seleccionar un empleado
    public function leerUnEmpleado()
    {
        $sql = 'SELECT idempleado, nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo
                FROM empleados
                WHERE idempleado = ?';
        $params = array($this->idempleado);
        return Database::getRow($sql, $params);
    }

    //funcion para leer los estados de empleado
    public function leerEstadosEmpleados()
    {
        $estados = array(array('Activo','Activo'), array('Inactivo','Inactivo'), array('Ausente con justificación','Ausente con justificación'), array('Ausente sin justificación','Ausente sin justificación'));
        return $estados;
    }

    //funcion para leer los generos
    public function leerGeneros()
    {
        $generos = array(array('Masculino','Masculino'), array('Femenino','Femenino'));
        return $generos;
    }

    public function leerCargos()
    {
        $cargos = array(array('Jefe','Jefe'), array('Gerente','Gerente'), array('Vendedor','Vendedor'));
        return $cargos;
    }

    //funcion para actualizar empleado
    public function actualizarEmpleado()
    {
        $sql = 'UPDATE empleados
                SET nombreemp = ?, telefonoemp = ?, correoemp = ?, nacimientoemp = ?, duiemp = ?, estadoempleado = ?, genero = ?, cargo = ?
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

    public function empleadoCargo()
    {
        $sql = 'SELECT cargo, count(idempleado) idempleado
        FROM empleados
        GROUP BY cargo ORDER BY idempleado ASC';
        return Database::getRows($sql);
    }


}
