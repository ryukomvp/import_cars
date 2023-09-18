<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/usuariosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuarios extends UsuariosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $pin = null;
    protected $tipo = null;
    protected $empleado = null;
    protected $estado = null;
    protected $correoemp = null;
    protected $idempleado = null;
    protected $verificacion = null;
    protected $intentos = null;
    protected $codigoveri = null;
    protected $codigoingresado = null;
    protected $palabra = null;
    protected $diasclave = null;


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
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correoemp = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idempleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVerificacion($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->verificacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIntentos($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->intentos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoveri($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigoveri = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoIngresado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->setCodigoIngresado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPalabra($value)
    {
        if (Validator::validateAlphabetic($value, 1, 10)) {
            $this->palabra = password_hash($value, PASSWORD_DEFAULT);
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

    public function getCorreo()
    {
        return $this->correoemp;
    }

    public function getIdEmpleado()
    {
        return $this->idempleado;
    }
    
    public function getVerificacion()
    {
        return $this->verificacion;
    }

    public function getIntentos()
    {
        return $this->intentos;
    }

    public function getCodigoveri()
    {
        return $this->codigoveri;
    }

    public function getCodigoIngresado()
    {
        return $this->codigoingresado;
    }

    public function getPalabra()
    {
        return $this->palabra;
    }

    public function getDiasClave()
    {
        return $this->diasclave;
    }
}

