<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/clientesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Cliente extends ClientesQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $giro = null;
    protected $dui = null;
    protected $correo = null;
    protected $telefono = null;
    protected $contacto = null;
    protected $tipopersona = null;
    protected $descuento = null;
    protected $exoneracion = null;
    protected $fechaini = null;
    protected $tipocliente = null;
    protected $idplazo = null;

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
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGiro($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 30)) {
            $this->giro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 11)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 10)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setContacto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 10)) {
            $this->contacto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPersona($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipopersona = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescuento($value)
    {
        if (Validator::validateDouble($value)) {
            $this->descuento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setExoneracion($value)
    {
        if (Validator::validateDouble($value)) {
            $this->exoneracion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaIni($value)
    {
        if (Validator::validatedate($value)) {
            $this->fechaini = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoCliente($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipocliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdPlazo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idplazo = $value;
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

    public function getGiro()
    {
        return $this->giro;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getContacto()
    {
        return $this->contacto;
    }

    public function getTipoPersona()
    {
        return $this->tipopersona;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function getExoneracion()
    {
        return $this->exoneracion;
    }

    public function getFechaIni()
    {
        return $this->fechaini;
    }

    public function getTipoCliente()
    {
        return $this->tipocliente;
    }

    public function getIdPlazo()
    {
        return $this->idplazo;
    }
}
