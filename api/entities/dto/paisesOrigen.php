<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/paisesOrigenQueries.php');

class PaisesOrigen extends PaisesOrigenQueries
{
    protected $id = null;
    protected $nomenclatura = null;
    protected $pais = null;

    //Metodos set para asignar valores a los atributos

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNomenclatura($value)
    {
        if (Validator::validateString($value, 1, 5)) {
            $this->nomenclatura = $value;
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
        return $this->id;
    }

    public function getNomenclatura()
    {
        return $this->nomenclatura;
    }

    public function getPais()
    {
        return $this->pais;
    }
}
