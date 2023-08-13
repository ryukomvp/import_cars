<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/cajasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Caja extends CajaQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombrecaja = null;
    protected $nombreequipo = null;
    protected $serieequipo = null;
    protected $modeloequipo = null;
    protected $idsucursal = null;
    protected $idusuario = null;

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

    public function setNombreCaja($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->nombrecaja = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreEquipo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->nombreequipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSerieEquipo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 15)) {
            $this->serieequipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModeloEquipo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->modeloequipo = $value;
            return true;
        } else {
            return false;
        }
    }   

    public function setIdSucursal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idsucursal = $value;
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



    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombreCaja()
    {
        return $this->nombrecaja;
    }

    public function getNombreEquipo()
    {
        return $this->nombreequipo;
    }

    public function getSerieEquipo()
    {
        return $this->serieequipo;
    }

    public function getModeloEquipo()
    {
        return $this->modeloequipo;
    }

    public function getIdSucursal()
    {
        return $this->idsucursal;
    }

    public function getIdUsuario()
    {
        return $this->idusuario;
    }
}
