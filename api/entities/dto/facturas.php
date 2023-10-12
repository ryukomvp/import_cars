<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/facturasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Facturas extends FacturasQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nofactura = null;
    protected $idcreditofiscal = null;
    protected $idcliente = null;
    protected $gmail = null;
    protected $fecha = null;
    protected $tipodocumento = null;
    protected $idencabezadotransaccion = null;

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

    public function setNoFactura($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->nofactura = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdCreditoFiscal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcreditofiscal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGmail($value)
    {
        if (Validator::validateEmail($value)) {
            $this->gmail = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoDocumento($value)
    {
        if (Validator::validateAlphanumeric($value,1,15)) {
            $this->tipodocumento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEncabezadoTransaccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idencabezadotransaccion = $value;
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

    public function getNoFactura()
    {
        return $this->nofactura;
    }

    public function getIdCreditoFiscal()
    {
        return $this->idcreditofiscal;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function getGmail()
    {
        return $this->gmail;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getTipoDocumento()
    {
        return $this->tipodocumento;
    }

    public function getIdEncabezadoTransaccion()
    {
        return $this->idencabezadotransaccion;
    }

    
}
