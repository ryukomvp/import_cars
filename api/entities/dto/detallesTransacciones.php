<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/detallesTransaccionQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class DetallesTransacciones extends DetallesTransaccionQueries
{
    //Declaración de atributos (propiedades).
    protected $id = null;
    protected $correlativo = null;
    protected $cantidad = null;
    protected $preciounitario = null;
    protected $ventanosujeta = null;
    protected $ventaexenta = null;
    protected $ventaafecta = null;
    protected $descuento = null;
    protected $valordescuento = null;
    protected $sumas = null;
    protected $subtotal = null;
    protected $ventatotal = null;
    protected $iva = null;
    protected $observaciones = null;
    protected $bodegaentrada = null;
    protected $bodegasalida = null;
    protected $producto = null;
    protected $descripcion = null;
    protected $encatransaccion = null;

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


    public function setIva($value)
    {
        if(Validator::validateDouble($value)) {
            $this->iva = $value;
            return true;
        } else{
            return false;
        }
    }

    public function setObservacion($value)
    {
        if (Validator::validateAlphabetic($value, 1, 200)) {
            $this->observaciones = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setBodegaEntrada($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->bodegaentrada = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setBodegaSalida($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->bodegasalida = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateAlphabetic($value, 1, 200)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEncatraccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->encatransaccion = $value;
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

    public function getBodega()
    {
        return $this->bodega;
    }

    public function getFamilia()
    {
        return $this->familia;
    }
}
