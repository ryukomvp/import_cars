<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/productosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Productos extends productosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $imagen = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $anio = null;
    protected $idCodigoComun = null;
    protected $idTipoProducto = null;
    protected $idProveedor = null;
    protected $idCategoria = null;
    protected $idModelo = null;
    protected $idPais = null;
    protected $estadoProducto = null;
    protected $ruta = '../images/productos/';

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

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 1000, 1000)) {
            $this->imagen = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAnio($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->anio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoComun($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idCodigoComun = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idTipoProducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProveedor($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idProveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idCategoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idModelo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPais($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idPais = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoProducto($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadoProducto = $value;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function getCodigoComun()
    {
        return $this->idCodigoComun;
    }

    public function getTipoProducto()
    {
        return $this->idTipoProducto;
    }

    public function getProveedor()
    {
        return $this->idProveedor;
    }

    public function getcategoria()
    {
        return $this->idCategoria;
    }

    public function getModelo()
    {
        return $this->idModelo;
    }

    public function getPais()
    {
        return $this->idPais;
    }

    public function getEstadoProducto()
    {
        return $this->estadoProducto;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
