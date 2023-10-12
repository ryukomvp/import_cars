<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/inventariosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Inventario extends InventarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombreprod = null;
    protected $idsucursal = null;
    protected $cantidads = null;
    protected $idbodega = null;
    protected $cantidadb = null;

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

    public function setNombreProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 70)) {
            $this->nombreprod = $value;
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

    public function setCantidads($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidads = $value;
            return true;
        } else {
            return false;
        }
    }  

    public function setIdBodega($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idbodega = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidadb($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadb = $value;
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

    public function getNombreProducto()
    {
        return $this->nombreprod;
    }

    public function getIdSucursals()
    {
        return $this->idsucursal;
    }

    public function getCantidads()
    {
        return $this->cantidads;
    }

    public function getIdBodega()
    {
        return $this->idsucursal;
    }

    public function getCantidadb()
    {
        return $this->cantidadb;
    }
}
