<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/paisesOrigenQueries.php');

class paisesOrigen extends paisesOrigenQueries
{
    public $idPais = null;
    public $pais = null;

    //Metodos set para asignar valores a los atributos

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idPais = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPais($value)
    {
        if (Validator::validateString($value, 1, 30)) {
            $this->pais = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodos get para obtener los valores de los atributos

    public function getId()
    {
        return $this->idPais;
    }

    public function getPais()
    {
        return $this->pais;
    }
    
}