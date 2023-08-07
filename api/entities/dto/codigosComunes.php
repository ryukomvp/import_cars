<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/codigosComunesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class CodigoComun extends CodigoComunQueries
{
    // Declaración de atributos (propiedades).
    protected $idcodigocomun = null;
    protected $nomenclatura = null;
    protected $codigo = null;


    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcodigocomun = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNomenclatura($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 10)) {
            $this->nomenclatura = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigo = $value;
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
        return $this->idcodigocomun;
    }

    public function getNomenclatura()
    {
        return $this->nomenclatura;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
}
