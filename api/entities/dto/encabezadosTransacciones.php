<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/encabezadosTransaccionesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Encabezado extends EncabezadosQueries
{
    protected $id = null;
    protected $correlativo = null;
    protected $fechahora = null;
    protected $lote = null;
    protected $poliza = null;
    protected $cajero = null;
    protected $tipopago = null;
    protected $codigotransaccion = null;
    protected $usuario = null;
    protected $proveedor = null;
    protected $parametro = null;
    protected $bodega = null;
    protected $sucursal = null;
    protected $observacion = null;
    protected $descripcion = null;
    protected $suma = null;
    protected $subtotal = null;
    protected $ventatotal = null;

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

    public function setFechaHora($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechahora = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLote($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->lote = $value;
            return true;
        } else {
            return false;
        }
    }  

    public function setPoliza($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->poliza = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setCajero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cajero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPago($value)
    {
        if (Validator::validateAlphanumeric($value,1,50)) {
            $this->tipopago = $value;
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

    
    public function setProveedor($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->proveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setParametro($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->parametro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setBodega($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->bodega = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSucursal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->sucursal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setObservacion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->observacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSuma($value)
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

    public function getFechahora()
    {
        return $this->fechahora;
    }

    public function getLote()
    {
        return $this->lote;
    }

    public function getPoliza()
    {
        return $this->poliza;
    }

    public function getCajero()
    {
        return $this->cajero;
    }

    public function getTipopago()
    {
        return $this->tipopago;
    }

    public function getCodigoTransaccion()
    {
        return $this->codigotransaccion;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function getParametro()
    {
        return $this->parametro;
    }

    public function getBodega()
    {
        return $this->bodega;
    }

    public function getSucursal()
    {
        return $this->sucursal;
    }

    public function getObservacion()
    {
        return $this->sucursal;
    }

    public function getDescripcion()
    {
        return $this->sucursal;
    }

    public function getSuma()
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
}
