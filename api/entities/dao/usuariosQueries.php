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
        $sql = 'UPDATE usuarios SET clave = ?, fechacontra = current_timestamp() WHERE idusuario = ?';
        $params = array($this->clave, $this->id);
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
        $sql = 'SELECT idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, e.nombreemp empleado, estadousuario, verificacion
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
                ORDER BY idusuario';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, idempleado, e.nombreemp empleado, estadousuario, verificacion
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
				WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE usuarios 
                SET nombreus = ?, pin = ?, tipousuario = ?, idempleado = ?, estadousuario = ?, verificacion = ?
                WHERE idusuario = ?';
        $params = array($this->nombre, $this->pin, $this->tipo, $this->empleado, $this->estado, $this->verificacion, $this->id);
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
        return Database::getRows($sql, $params);
    }

    //Verificar si el usuario tiene activa la verificacion en 2 pasos//
    // public function verificarSegundoFactor()
    // {
    //     $sql = 'SELECT verificacion FROM usuarios 
    //     WHERE idusuario = ?';
    //     $params = array($this->id)
    //     return Database::getRow($sql, $params);
    // }

    public function verificarUsuarioEmp($nombre)
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
    
    public function verificarCorreo($correoemp)
    {
        $sql = 'SELECT usuarios.idempleado, empleados.correoemp
        FROM empleados
        INNER JOIN usuarios ON empleados.idempleado = usuarios.idempleado
        WHERE 	correoemp = ?';
        $params = array($correoemp);
        if ($data = Database::getRow($sql, $params)) {
            $this->idempleado = $data['idempleado'];
            $this->correoemp = $correoemp;
            return true;
        } else {
            return false;
        }
    }

    public function verificarPin($pin)
    {
        $sql = 'SELECT idusuario FROM usuarios WHERE pin = ?';
        $params = array($pin);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idusuario'];
            $this->pin = $pin;
            return true;
        } else {
            return false;
        }
    }

    // Método para leer los intentos de iniciar sesión realizados.
    public function leerIntentos()
    {
        $sql = 'SELECT intentos FROM usuarios
                WHERE nombreus = ?';
        $params = array($this->nombre);
        return Database::getRow($sql, $params);
    }

    // public boolean verificarIntentos($pin)
    // {
    //     $sql = 'SELECT * FROM usuarios WHERE nombreus = ? AND intentos = 3';
    //     $params = array($usuario);
    //     if ($data = Database::getRow($sql, $params)) {
    //         // $this->id = $data['idusuario'];
    //         // $this->pin = $pin;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // Método para actualizar los intentos de inicio de sesión.
    public function actualizarIntentos()
    {
        $sql = 'UPDATE usuarios SET intentos = ? WHERE nombreus = ?';
        $params = array($this->intentos, $this->nombre);
        return Database::executeRow($sql, $params);
    }    

}
