<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para realizar operaciones de gestión en la cuenta del usuario
    */
    public function checkUser($alias)
    {
        $sql = 'SELECT idusuario FROM usuarios WHERE nombre = ?';
        $params = array($nombre);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idusuario'];
            $this->alias = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM usuarios WHERE idusuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave = ? WHERE idusuario = ?';
        $params = array($this->clave, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT idusuario, nombre, pin
                FROM usuarios
                WHERE idusuario = ?';
        $params = array($_SESSION['idusuario']);
        return Database::getRow($sql, $params);
    }

    // public function editProfile()
    // {
    //     $sql = 'UPDATE usuarios
    //             SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?, alias_usuario = ?
    //             WHERE id_usuario = ?';
    //     $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $_SESSION['id_usuario']);
    //     return Database::executeRow($sql, $params);
    // }

    /*
    *   Métodos para realizar operaciones de gestión en la tabla usuarios
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idusuario, u.nombre, contrasenia, pin, tipousuario, e.nombre, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
				WHERE u.nombre ILIKE ? OR e.nombre ILIKE ?
                ORDER BY idusuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre, clave, pin, tipousuario, idempleado, estadousuario)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->clave, $this->pin, $this->tipo, $this->empleado, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idusuario, u.nombre, contrasenia, pin, tipousuario, e.nombre, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
                ORDER BY idusuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idusuario, u.nombre, contrasenia, pin, tipousuario, e.nombre, estadousuario
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
				WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readTipo()
    {
        $sql = 'SELECT unnest(enum_range(NULL::tiposusuarios)) val, unnest(enum_range(NULL::tiposusuarios)) text';
        return Database::getRows($sql);
    }

    public function readEstado()
    {
        $sql = 'SELECT unnest(enum_range(NULL::estadosusuarios)) val, unnest(enum_range(NULL::estadosusuarios)) text';
        return Database::getRows($sql);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombres = ?, pin = ?, tipousuario = ?, idempleado = ?, estadousuario = ?
                WHERE idusuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function estadoActivo()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Activo'
                WHERE idusuario = ? AND estadousuario = 'Inactivo'";
        $params = array($this->id)
    }

    public function estadoInactivo()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Activo'";
        $params = array($this->id)
    }

    public function desbloquearUsuario()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Bloqueado'";
        $params = array($this->id)
    }
}
