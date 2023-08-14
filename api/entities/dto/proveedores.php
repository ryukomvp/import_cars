<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/proveedoresQueries.php');

class proveedores extends proveedoresQueries
{
    protected $id = null;
    protected $nombreprov = null;
    protected $telefonoprov = null;
    protected $correoprov = null;
    protected $codigoprov = null;
    protected $codigomaestroprov = null;
    protected $duiprov = null;
    protected $idmoneda = null;
    protected $numeroregistroprov = null;

    //Metodos set para asignar valores a los atributos

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
        if (Validator::validateString($value, 1, 25)) {
            $this->nombreprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefonoprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correoprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigoprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoMaestro($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigomaestroprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if (Validator::validateDUI($value)) {
            $this->duiprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdMoneda($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idmoneda = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNumeroRegistroProv($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->numeroregistroprov = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodos get para obtener los valores de los atributos

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombreprov;
    }

    public function getTelefono()
    {
        return $this->telefonoprov;
    }

    public function getCorreo()
    {
        return $this->correoprov;
    }

    public function getCodigoProv()
    {
        return $this->codigoprov;
    }

    public function getCodigoMaestroProv()
    {
        return $this->codigomaestroprov;
    }

    public function getDui()
    {
        return $this->duiprov;
    }

    public function getIdMoneda()
    {
        return $this->idmoneda;
    }

    public function getNumeroRegistroProv()
    {
        return $this->numeroregistroprov;
    }
}
