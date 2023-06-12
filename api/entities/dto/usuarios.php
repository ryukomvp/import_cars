<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/usuariosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class usuarios extends usuariosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $pin = null;
    protected $tipo = null;
    protected $empleado = null;
    protected $estado = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setPin($value)
    {
        if (Validator::validateString($value, 1, 10)) {
            $this->pin = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getPin()
    {
        return $this->pin;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getEmpleado()
    {
        return $this->empleado;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
