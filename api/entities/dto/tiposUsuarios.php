<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/tiposUsuariosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad TIPOS PRODUCTOS.
*/
class TipoUsuario extends TiposUsuariosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombretipous = null;
    protected $marcas = null;
    protected $paisesdeorigen = null;
    protected $monedas = null;
    protected $familias = null;
    protected $categorias = null;
    protected $codigoscomunes = null;
    protected $tiposproductos = null;
    protected $codigostransacciones = null;
    protected $codigosplazos = null;
    protected $sucursales = null;
    protected $plazos = null;
    protected $contactos = null;
    protected $parametros = null;
    protected $proveedores = null;
    protected $modelos = null;
    protected $empleados = null;
    protected $clientes = null;
    protected $usuarios = null;
    protected $cajas = null;
    protected $cajeros = null;
    protected $vendedores = null;
    protected $bodegas = null;
    protected $familiasbodegas = null;
    protected $productos = null;
    protected $encabezadostransacciones = null;
    protected $detallestransacciones = null;
    protected $tiposusuarios = null;
    protected $bitacoras = null;
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
    public function setNombretipous($value)
    {
        if (Validator::validateString($value, 1, 25)) {
            $this->nombretipous = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setMarcas($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->marcas = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPaisesdeorigen($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->paisesdeorigen = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setMonedas($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->monedas = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setFamilias($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->familias = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCategorias($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->categorias = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCodigoscomunes($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->codigoscomunes = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTiposproductos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->tiposproductos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCodigostransacciones($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->codigostransacciones = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCodigosplazos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->codigosplazos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setSucursales($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->sucursales = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPlazos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->plazos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setContactos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->contactos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setParametros($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->parametros = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProveedores($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->proveedores = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->modelos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEmpleados($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->empleados = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setClientes($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->clientes = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setUsuarios($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->usuarios = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCajas($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->cajas = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCajeros($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->cajeros = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setVendedores($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->vendedores = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setBodegas($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->bodegas = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setFamiliasbodegas($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->familiasbodegas = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->productos = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEncabezadostransacciones($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->encabezadostransacciones = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDetallestransacciones($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->detallestransacciones = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTiposusuarios($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->tiposusuarios = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setBitacoras($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->bitacoras = $value;
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
    public function getNombretipous()
    {
        return $this->nombretipous;
    }
    public function getMarcas()
    {
        return $this->marcas;
    }
    public function getPaisesdeorigen()
    {
        return $this->paisesdeorigen;
    }
    public function getMonedas()
    {
        return $this->monedas;
    }
    public function getFamilias()
    {
        return $this->familias;
    }
    public function getCategorias()
    {
        return $this->categorias;
    }
    public function getCodigoscomunes()
    {
        return $this->codigoscomunes;
    }
    public function getTiposproductos()
    {
        return $this->tiposproductos;
    }
    public function getCodigostransacciones()
    {
        return $this->codigostransacciones;
    }
    public function getCodigosplazos()
    {
        return $this->codigosplazos;
    }
    public function getSucursales()
    {
        return $this->sucursales;
    }
    public function getPlazos()
    {
        return $this->plazos;
    }
    public function getContactos()
    {
        return $this->contactos;
    }
    public function getParametros()
    {
        return $this->parametros;
    }
    public function getProveedores()
    {
        return $this->proveedores;
    }
    public function getModelos()
    {
        return $this->modelos;
    }
    public function getEmpleados()
    {
        return $this->empleados;
    }
    public function getClientes()
    {
        return $this->clientes;
    }
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    public function getCajas()
    {
        return $this->cajas;
    }
    public function getCajeros()
    {
        return $this->cajeros;
    }
    public function getVendedores()
    {
        return $this->vendedores;
    }
    public function getBodegas()
    {
        return $this->bodegas;
    }
    public function getFamiliasbodegas()
    {
        return $this->familiasbodegas;
    }
    public function getProductos()
    {
        return $this->productos;
    }
    public function getEncabezadostransacciones()
    {
        return $this->encabezadostransacciones;
    }
    public function getDetallestransacciones()
    {
        return $this->detallestransacciones;
    }
    public function getTiposusuarios()
    {
        return $this->tiposusuarios;
    }
    public function getBitacoras()
    {
        return $this->bitacoras;
    }
}
