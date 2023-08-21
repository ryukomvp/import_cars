<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/plazosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Plazos extends PlazosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $descripcion = null;
    protected $vencimiento = null;
    protected $idcodigoplazo = null;
    protected $tipoplazo = null;


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

    public function setDescripcion($value)
    {
        if (Validator::validateAlphanumeric($value,1,30)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVencimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->vencimiento = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdCodigoPlazo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcodigoplazo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPlazo($value)
    {
        if (Validator::validateAlphanumeric($value,1,50)) {
            $this->tipoplazo = $value;
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

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    public function getIdCodigoPlazo()
    {
        return $this->idcodigoplazo;
    }

    public function getTipoPlazo()
    {
        return $this->tipoplazo;
    }
}
