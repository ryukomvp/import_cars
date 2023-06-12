<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/productosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Productos extends ProductosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $imagen = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $anio = null;
    protected $codigoComun = null;
    protected $tipoProducto = null;
    protected $proveedor = null;
    protected $categoria = null;
    protected $modelo = null;
    protected $pais = null;
    protected $estadoProducto = null;
    protected $ruta = '../images/products/';

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
        if (Validator::validateDate($value)) {
            $this->anio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoComun($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigoComun = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipoProducto = $value;
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

    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPais($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->pais = $value;
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

    public function setRuta($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencia = $value;
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

    public function getCodigo()
    {
        return $this->codigo;
    }
   
    public function getDimensiones()
    {
        return $this->dimensiones;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getExistencia()
    {
        return $this->existencia;
    }
    
    public function getRuta()
    {
        return $this->ruta;
    }
}
