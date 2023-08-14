<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuariosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    public function verificarUsuario($nombre)
    {
        $sql = 'SELECT idusuario FROM usuarios WHERE nombreus = ?';
        $params = array($nombre);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idusuario'];
            $this->nombre = $nombre;
            return true;
        } else {
            return false;
        }
    }

    public function verificarClave($password)
    {
        $sql = 'SELECT contrasenia FROM usuarios WHERE idusuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia'])) {
            return true;
        } else {
            return false;
        }
    }

    public function cambiarClave()
    {
        $sql = 'UPDATE usuarios SET clave = ? WHERE idusuario = ?';
        $params = array($this->clave, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar operaciones de gestión en la tabla usuarios
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, e.nombreemp empleado, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
                WHERE u.nombreus LIKE ?
                ORDER BY idusuario';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO usuarios(nombreus, contrasenia, pin, tipousuario, idempleado, estadousuario)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->clave, $this->pin, $this->tipo, $this->empleado, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, e.nombreemp empleado, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
                ORDER BY idusuario';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, idempleado, e.nombreemp empleado, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
				WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE usuarios 
                SET nombreus = ?, pin = ?, tipousuario = ?, idempleado = ?, estadousuario = ?
                WHERE idusuario = ?';
        $params = array($this->nombre, $this->pin, $this->tipo, $this->empleado, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM usuarios
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerTipos()
    {
        $tipos = array(array('Administrador','Administrador'), array('Gerente','Gerente'), array('Vendedor','Vendedor'));
        return $tipos;
    }

    public function leerEmpleados()
    {
        $sql = 'SELECT idempleado, nombreemp FROM empleados
                ORDER BY idempleado';
        return Database::getRows($sql);
    }

    public function leerEstados()
    {
        $estados = array(array('Activo','Activo'), array('Inactivo','Inactivo'), array('Bloqueado','Bloqueado'));
        return $estados;
    }

    public function estadoActivo()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Activo'
                WHERE idusuario = ? AND estadousuario = 'Inactivo'";
        $params = array($this->id);
    }

    public function estadoInactivo()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Activo'";
        $params = array($this->id);
    }

    public function desbloquearUsuario()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Bloqueado'";
        $params = array($this->id);
    }

    public function reporteUsuariosTipo()
    {
        $sql = 'SELECT u.nombreus AS usuario, e.nombreemp AS empleado, u.estadousuario AS estado FROM usuarios u
                INNER JOIN empleados e
                ON e.idempleado = u.idempleado
                WHERE tipousuario = ?
                ORDER BY e.nombreemp ASC';
        $params = array($this->tipo);
    }
}
