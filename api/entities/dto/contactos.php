<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/contactosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Contacto extends ContactoQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $telefonocontact = null;
    protected $celularcontact = null;
    protected $correocontact = null;
    protected $idsucursal = null;

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

    public function setTelefonoContacto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->telefonocontact = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCelularContacto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->celularcontact = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreoContacto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 20)) {
            $this->correocontact = $value;
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



    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getTelefonoContacto()
    {
        return $this->telefonocontact;
    }

    public function getCelularContacto()
    {
        return $this->celularcontact;
    }

    public function getCorreo()
    {
        return $this->correocontact;
    }

    public function getIdSucursal()
    {
        return $this->idsucursal;
    }
}
