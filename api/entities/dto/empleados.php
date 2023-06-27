<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/empleadosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class empleados extends empleadosQueries
{
    // Declaración de atributos (propiedades).
    protected $idempleado = null;
    protected $nombre = null;
    protected $telefono = null;
    protected $correo = null;
    protected $nacimiento = null;
    protected $tipoDocumento = null;
    protected $documento = null;
    protected $estado = null;
    protected $genero = null;
    protected $cargo = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */

    // Método para validar y asignar el id.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el nombre.
    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el telefono.
    public function setTelefono($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el correo.
    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar la fecha de nacimiento.
    public function setNacimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->nacimiento = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el tipo de documento.
    public function setTipoDocumento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipoDocumento = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el documento.
    public function setDocumento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->documento = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el estado.
    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el genero.
    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }
    }

    // Método para validar y asignar el cargo.
    public function setCargo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cargo = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */

    // Método para obtener el id.
    public function getId()
    {
        return $this->id;
    }

    // Método para obtener el nombre.
    public function getNombre()
    {
        return $this->nombre;
    }

    // Método para obtener el telefono.
    public function getTelefono()
    {
        return $this->telefono;
    }

    // Método para obtener el correo.
    public function getCorreo()
    {
        return $this->correo;
    }

    // Método para obtener la fecha de nacimiento.
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    // Método para obtener el tipo de documento.
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    // Método para obtener el documento.
    public function getDocumento()
    {
        return $this->documento;
    }

    // Método para obtener el estado.
    public function getEstado()
    {
        return $this->estado;
    }

    // Método para obtener el genero.
    public function getGenero()
    {
        return $this->genero;
    }

    // Método para obtener el cargo.
    public function getCargo()
    {
        return $this->cargo;
    }
}