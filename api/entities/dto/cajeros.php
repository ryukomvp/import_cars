<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/cajerosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Cajero extends CajeroQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombrecajero = null;
    protected $estadocajero = null;
    protected $fechaingreso = null;
    protected $idcaja = null;

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

    public function setNombreCajero($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->nombrecajero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadocajero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaIngreso($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaingreso = $value;
            return true;
        } else {
            return false;
        }
    }  

    public function setIdCaja($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcaja = $value;
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

    public function getCajero()
    {
        return $this->nombrecajero;
    }

    public function getEstado()
    {
        return $this->estadocajero;
    }

    public function getFecha()
    {
        return $this->fechaingreso;
    }

    public function getIdCaja()
    {
        return $this->idcaja;
    }
}
