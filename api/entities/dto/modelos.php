<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/modelosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad MARCA.
*/
class Modelo extends ModeloQueries
{
    //Declaración de atributos(propiedades).
    protected $id = null;
    protected $modelo = null;
    protected $marca = null;

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

    public function setModelo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMarca($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->marca = $value;
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

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getMarca()
    {
        return $this->marca;
    }
}
