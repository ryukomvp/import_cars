<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/proveedoresQueries.php');

class proveedores extends proveedoresQueries
{
    public $idproveedor = null;
    public $nombre = null;
    public $telefono = null;
    public $correo = null;
    public $fechacompra = null;
    public $saldoinicial = null;
    public $saldoactual = null;
    public $codigoprov = null;
    public $codigomaestroprov = null;
    public $dui = null;
    public $idmoneda = null;
    public $numeroregistroprov = null;

    //Metodos set para asignar valores a los atributos

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idproveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1, 25)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaCompra($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechacompra = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSaldoInicial($value)
    {
        if (Validator::validateMoney($value)) {
            $this->saldoinicial = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSaldoActual($value)
    {
        if (Validator::validateMoney($value)) {
            $this->saldoactual = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoProv($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigoprov = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoMaestroProv($value)
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
        if (Validator::validateString($value, 1, 20)) {
            $this->dui = $value;
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
        return $this->idproveedor;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getFechaCompra()
    {
        return $this->fechacompra;
    }

    public function getSaldoInicial()
    {
        return $this->saldoinicial;
    }

    public function getSaldoActual()
    {
        return $this->saldoactual;
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
        return $this->dui;
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