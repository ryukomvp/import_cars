<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/encabezadosTransaccionesQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Encabezado extends EncabezadosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nocomprobante = null;
    protected $fechatransac = null;
    protected $lote = null;
    protected $npoliza = null;
    protected $idbodega = null;
    protected $idcajero = null;
    protected $tipopago = null;
    protected $idcodigotransaccion = null;
    protected $idcliente = null;
    protected $idvendedor = null;
    protected $idproveedor = null;
    protected $idparametro = null; 
    protected $iddetalletransaccion = null;

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

    public function setNoComprobante($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->nocomprobante = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaTransac($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechatransac = $value;
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

    public function setNoPoliza($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->npoliza = $value;
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

    public function setIdCajero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcajero = $value;
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

    public function setIdCodigoTransaccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcodigotransaccion = $value;
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


    public function setIdVendedor($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idvendedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdProveedor($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idproveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdParametro($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idparametro = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalleTransaccion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->iddetalletransaccion = $value;
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

    public function getNoComprobante()
    {
        return $this->nocomprobante;
    }

    public function getFechaTransac()
    {
        return $this->fechatransac;
    }

    public function getLote()
    {
        return $this->lote;
    }

    public function getNoPoliza()
    {
        return $this->npoliza;
    }

    public function getIdBodega()
    {
        return $this->idbodega;
    }

    public function getIdCajero()
    {
        return $this->idcajero;
    }

    public function getTipoPago()
    {
        return $this->tipopago;
    }

    public function getIdCodigoTransaccion()
    {
        return $this->idcodigotransaccion;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function getIdVendedor()
    {
        return $this->idvendedor;
    }

    public function getIdProveedor()
    {
        return $this->idproveedor;
    }

    public function getIdParametro()
    {
        return $this->idparametro;
    }

    public function getIdDetalleTransaccion()
    {
        return $this->iddetalletransaccion;
    }
}
