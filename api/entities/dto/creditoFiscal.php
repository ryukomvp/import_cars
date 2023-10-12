<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/creditoFiscalQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class CreditoFiscal extends CreditoFiscalQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $noregistro = null;
    protected $fecha = null;
    protected $duinit = null;
    protected $tipodocumento = null;
    protected $tipodepersona = null;
    protected $razonsocial = null;
    protected $empresa = null;
    protected $email = null;
    protected $direccion = null;
    protected $idpais = null;
    protected $giro = null;
    protected $categoria = null;
    protected $telefono = null;
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

    public function setNoRegistro($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->noregistro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDuiNit($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->duinit = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoDocumento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipodocumento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPersona($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipodepersona = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRazonSocial($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->razonsocial = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmpresa($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->empresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmail($value)
    {
        if (Validator::validateEmail($value)) {
            $this->email = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdPais($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idpais = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGiro($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->giro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCategoria($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 10)) {
            $this->categoria = $value;
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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNoRegistro()
    {
        return $this->noregistro;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getDuiNit()
    {
        return $this->duinit;
    }

    public function getTipoDocumento()
    {
        return $this->tipodocumento;
    }

    public function getTipoPersona()
    {
        return $this->tipodepersona;
    }

    public function getRazonSocial()
    {
        return $this->razonsocial;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getIdPais()
    {
        return $this->idpais;
    }

    public function getGiro()
    {
        return $this->giro;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
}
