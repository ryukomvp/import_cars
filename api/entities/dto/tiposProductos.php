<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/tiposProductosQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class tiposProductos extends tiposProductosQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $tipoProducto = null;

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

    public function setTipoProducto($value)
    {
        if (Validator::validateAlphabetic($value, 1, 30)) {
            $this->tipoProducto = $value;
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

    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }
}
