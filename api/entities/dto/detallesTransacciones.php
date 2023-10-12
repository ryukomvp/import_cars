<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/detallesTransaccionesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class DetallesTransacciones extends DetallesTransaccionQueries
{
    //Declaración de atributos (propiedades).
    protected $id = null;
    protected $correlativo = null;
    protected $producto= null;
    protected $cantidad= null;
    protected $preciounitario= null;
    protected $ventasnosujetas = null;
    protected $ventasexentas = null;
    protected $ventasafectas = null;
    protected $descuento = null;
    protected $valordescuento = null;
    protected $encabezadotransaccion = null;
    protected $codigotransaccion = null;
    protected $usuario = null;

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
            $this->correlativo = $value;
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

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
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
            $this->ventasnosujetas = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaExenta($value)
    {
        if (Validator::validateMoney($value)) {
            $this->ventasexentas = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setVentaAfecta($value)
    {
        if (Validator::validateMoney($value)) {
            $this->ventasafectas = $value;
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
        if (Validator::validateDouble($value)) {
            $this->valordescuento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEncabezadoTransaccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->encabezadotransaccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoTransaccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigotransaccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->usuario = $value;
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

    public function getProducto()
    {
        return $this->producto;
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
        return $this->ventasnosujetas;
    }

    public function getVentaExenta()
    {
        return $this->ventasexentas;
    }

    public function getVentaAfecta()
    {
        return $this->ventasafectas;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function getValorDescuento()
    {
        return $this->valordescuento;
    }

    public function getEncabezadoTransaccion()
    {
        return $this->encabezadotransaccion;
    }

    public function getCodigoTransaccion()
    {
        return $this->codigotransaccion;
    }
}
