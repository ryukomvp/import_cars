<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/products.queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Product extends ProductQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $codigocomun = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $codigo = null;
    protected $dimensiones = null;
    protected $categoria = null;
    protected $material = null;
    protected $proveedor = null;
    protected $estado = null;
    protected $existencia = null;
    protected $ruta = '../../images/products/';

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
        if (Validator::validateImageFile($file, 600, 600)) {
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

    public function setCodigo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDimensiones($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->dimensiones = $value;
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

    public function setMaterial($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->material = $value;
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

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setExistencia($value)
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
