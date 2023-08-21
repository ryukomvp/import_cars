<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/familiasBodegasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class FamiliasBodegas extends FamiliasBodegasQueries
{
    //Declaración de atributos (propiedades).
    protected $id = null;
    protected $bodega = null;
    protected $familia = null;

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

    public function setBodega($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->bodega = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFamilia($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->familia = $value;
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

    public function getBodega()
    {
        return $this->bodega;
    }

    public function getFamilia()
    {
        return $this->familia;
    }
}
