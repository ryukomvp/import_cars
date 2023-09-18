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

    public function verificarBloqueo($nombre)
    {
        $sql = "SELECT idusuario FROM usuarios WHERE nombreus = ? AND estadousuario != 'Bloqueado'";
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
        $sql = 'SELECT contrasenia, intentos FROM usuarios WHERE idusuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se capturan los intentos antes de verificar la contraseña.
        $this->intentos = $data['intentos'];
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
        return Database::executeRow($sql, $params);
    }

    public function estadoInactivo()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Activo'";
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function desbloquearUsuario()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Inactivo'
                WHERE idusuario = ? AND estadousuario = 'Bloqueado'";
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function bloquearUsuario()
    {
        $sql = "UPDATE usuarios SET estadousuario = 'Bloqueado'
                WHERE idusuario = ?";
        $params = array($this->id);
        return Database::executeRow($sql, $params);

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
        $sql = 'SELECT usuarios.idusuario, usuarios.idempleado, empleados.correoemp
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

    // Método para actualizar los intentos de inicio de sesión.
    public function actualizarIntentos()
    {
        $sql = 'UPDATE usuarios SET intentos = intentos + 1 WHERE nombreus = ?';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }    

    //Método para actualizar el codigo enviado al correo
    public function ingresarCodigo($codigoveri)
    {
        $sql = 'UPDATE usuarios SET codigoveri = ? 
                WHERE idusuario = ?';
        $params = array($codigoveri, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para verificar si el usuario tiene activa la verificaicion en dos factores y mostrar el modal para el ingreso del codigo
    public function verificarSegundoFactor()
    {
        $sql = 'SELECT verificacion 
                FROM usuarios
                WHERE idusuario = ?';
        $params = array($this->verificacion, $this->id);
        return Database::getRow($sql, $params);
    }

    //Método para verificar si el codigo generado y el ingresado por el usuario coinciden
    public function verificarCodigo($codigoingresado)
    {
        $sql = 'SELECT codigoveri
        FROM usuarios
        WHERE codigoveri = ?';
        $params = array($codigoingresado);
        if ($data = Database::getRow($sql, $params)) {
            $this->codigoingresado = $codigoingresado;
            return true;
        } else {
            return false;
        }
    }

    // Método para leer el perfil del usuario.
    public function leerPerfil()
    {
        $sql = 'SELECT idusuario, u.nombreus usuario, idempleado, e.nombreemp empleado, tipousuario, e.cargo, e.correoemp
                FROM usuarios u INNER JOIN empleados e USING(idempleado)
				WHERE idusuario = ?';
        $params = array($_SESSION['idusuario']);
        return Database::getRow($sql, $params);
    }

    public function leerTipoUsuario()
    {
        $sql = 'SELECT idusuario, nombreus, idtipousuario
                FROM usuarios 
                WHERE idtipousuario = ?';
        $params = array($this->tipo);
        return Database::getRow($sql, $params);
    }

    public function recuperarContrasenia()
    {
        $sql = 'UPDATE usuarios u
        INNER JOIN empleados e ON u.idempleado = e.idempleado
        SET u.contrasenia = ?, usuarios.fechacontra = current_timestamp() 
        WHERE e.correoemp = ?';
        $params = array($this->clave, $this->correoemp);
        return Database::executeRow($sql, $params);
    }

    public function leerUnRegistroPorCorreo()
    {
        $sql = 'SELECT u.idusuario, u.nombreus usuario, contrasenia, pin, tipousuario, idempleado, e.nombreemp empleado, estadousuario, verificacion
        FROM usuarios u INNER JOIN empleados e USING(idempleado)
        WHERE  e.correoemp= ?';
        $params = array($this->correo);
        return Database::getRow($sql, $params);
    }

    public function leerDiasContra()
    {
        $sql = 'SELECT DATEDIFF(CURRENT_DATE, fecha_clave) as dias FROM usuarios WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
}



