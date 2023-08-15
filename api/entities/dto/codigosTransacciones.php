<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/codigosTransaccionesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class CodigoTransacciones extends CodigosTransaccionesQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $codigo = null;
    protected $nombrecodigo = null;


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

    public function setCodigo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreCodigo($value)
    {
        if (Validator::validateAlphanumeric($value,1,100)) {
            $this->nombrecodigo = $value;
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

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getNombreCodigo()
    {
        return $this->nombrecodigo;
    }
}
