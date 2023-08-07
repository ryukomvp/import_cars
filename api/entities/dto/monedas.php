<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/monedasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Moneda extends MonedasQueries
{
    // Declaración de atributos (propiedades).
    protected $idmoneda = null;
    protected $moneda = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idmoneda = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMoneda($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 30)) {
            $this->moneda = $value;
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
        return $this->idmoneda;
    }

    public function getMoneda()
    {
        return $this->moneda;
    }
}
