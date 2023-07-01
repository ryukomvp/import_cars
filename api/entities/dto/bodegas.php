<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/bodegasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad BODEGAS.
*/
class Bodegas extends BodegasQueries
{
    //Declaración de atributos (propiedades).
    protected $id = null;
    protected $numerobodega = null;
    protected $direccion = null;
    protected $sucursal = null;

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

    public function setNumeroBodega($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->numerobodega = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSucursal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->sucursal = $value;
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

    public function getNumeroBodega()
    {
        return $this->numerobodega;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getSucursal()
    {
        return $this->sucursal;
    }
}