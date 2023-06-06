<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/marcasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad MARCA.
*/
class Marca extends MarcaQueries
{
    //Declaracion de atributos(propiedades).
    protected $id = null;
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

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 25) {
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

    public function getNombre()
    {
        return $this->nombre;
    }
}