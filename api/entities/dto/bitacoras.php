<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/bitacorasQueries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Bitacora extends BitacoraQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $mensaje = null;
    protected $fechabitacora = null;

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

    public function setMensaje($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 200)) {
            $this->mensaje = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaBitacora($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechabitacora = $value;
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

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function getFechaBitacora()
    {
        return $this->fechabitacora;
    }
}
