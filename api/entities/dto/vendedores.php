<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/vendedoresQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Vendedor extends VendedorQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $idusuario = null;
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

    public function setIdUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idusuario = $value;
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

    public function getIdUsuario()
    {
        return $this->idusuario;
    }

    public function getIdCaja()
    {
        return $this->idcaja;
    }
}
