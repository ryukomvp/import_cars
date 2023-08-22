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
    protected $suma = null;
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

    public function setCorrelativo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->encatransaccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->encatransaccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecioUnitario($value)
    {
        if (Validator::validateMoney($value)) {
            $this->preciounitario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaNoSujeta($value)
    {
        if (Validator::validateMoney($value)) {
            $this->ventanosujeta = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaExenta($value)
    {
        if (Validator::validateMoney($value)) {
            $this->subtotal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaAfecta($value)
    {
        if (Validator::validateMoney($value)) {
            $this->ventaafecta = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescuento($value)
    {
        if(Validator::validateDouble($value)) {
            $this->descuento = $value;
            return true;
        } else{
            return false;
        }
    }

    public function setValorDescuento($value)
    {
        if (Validator::validateMoney($value)) {
            $this->subtotal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSumas($value)
    {
        if (Validator::validateMoney($value)) {
            $this->suma = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSubTotal($value)
    {
        if (Validator::validateMoney($value)) {
            $this->subtotal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaTotal($value)
    {
        if (Validator::validateMoney($value)) {
            $this->ventatotal = $value;
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

    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecioUnitario()
    {
        return $this->preciounitario;
    }
    
    public function getVentaNoSujeta()
    {
        return $this->ventanosujeta;
    }

    public function getVentaExenta()
    {
        return $this->ventaexenta;
    }

    public function getVentaAfecta()
    {
        return $this->ventaafecta;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function getValorDescuento()
    {
        return $this->valordescuento;
    }

    public function getSumas()
    {
        return $this->suma;
    }

    public function getSubTotal()
    {
        return $this->subtotal;
    }

    public function getVentaTotal()
    {
        return $this->ventatotal;
    }

    public function getIva()
    {
        return $this->iva;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function getBodegaEntrada()
    {
        return $this->bodegaentrada;
    }

    public function getBodegaSalida()
    {
        return $this->bodegasalida;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getEncaTransaccion()
    {
        return $this->encatransaccion;
    }
}
