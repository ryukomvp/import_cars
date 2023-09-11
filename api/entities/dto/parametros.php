<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/parametrosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Parametro extends ParametrosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombreemp = null;
    protected $direccionemp = null;
    protected $porcentaje = null;
    protected $registro = null;
    protected $giroempresa = null;
    protected $nit = null;
    protected $dui = null;
    protected $idcontacto = null;


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

    public function setNombreEmp($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombreemp = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionEmp($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 150)) {
            $this->direccionemp = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPorcentaje($value)
    {
        if (Validator::validateDouble($value)) {
            $this->porcentaje = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRegistro($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->registro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGiroEmpresa($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 80)) {
            $this->giroempresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNit($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->nit = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if (Validator::validateDUI($value)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdContacto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcontacto = $value;
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

    public function getNombreEmp()
    {
        return $this->nombreemp;
    }

    public function getDireccionEmp()
    {
        return $this->direccionemp;
    }

    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function getGiroEmpresa()
    {
        return $this->giroempresa;
    }

    public function getNit()
    {
        return $this->nit;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getIdContacto()
    {
        return $this->idcontacto;
    }
    

    
}
