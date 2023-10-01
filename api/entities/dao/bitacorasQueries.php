<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class BitacoraQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idbitacora, mensaje, fechabitacora
                FROM bitacoras
                WHERE mensaje LIKE ? OR fechabitacora LIKE ?
                ORDER BY fechabitacora';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO bitacoras(mensaje, fechabitacora)
                VALUES(?,?)';
        $params = array($this->mensaje, $this->fechabitacora);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idbitacora, mensaje, fechabitacora
                FROM bitacoras
                ORDER BY mensaje';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idbitacora, mensaje, fechabitacora
                FROM bitacoras
                WHERE idbitacora = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE bitacoras
                SET mensaje = ?, fechabitacora = ?
                WHERE idbitacora = ?';
        $params = array($this->mensaje, $this->fechabitacora, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM bitacoras
                WHERE idbitacora = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
