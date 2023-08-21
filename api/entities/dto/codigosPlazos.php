<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/codigosPlazosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class CodigoPlazo extends CodigosPlazosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $plazo = null;
    protected $dias = null;


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

    public function setPlazo($value)
    {
        if (Validator::validateAlphanumeric($value,1,30)) {
            $this->plazo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDias($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->dias = $value;
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

    public function getPlazo()
    {
        return $this->plazo;
    }

    public function getDias()
    {
        return $this->dias;
    }
}
