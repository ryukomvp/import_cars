<?php
require_once('../helpers/database.php');

class PlazosQueries
{
    // Funcion para buscar paises de origen
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idplazo, descripcion, vencimiento, plazo, tipoplazo
                FROM plazos INNER JOIN codigosplazos ON plazos.idcodigoplazo = codigosplazos.idcodigoplazo
                WHERE descripcion LIKE ? OR vencimiento LIKE ?
                ORDER BY tipoplazo';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    // Función para crear paises de origen
    public function crearRegistro()
    {
        $sql = 'INSERT INTO plazos(descripcion, vencimiento, idcodigoplazo, tipoplazo)
                VALUES(?,?,?,?)';
        $params = array($this->descripcion, $this->vencimiento, $this->idcodigoplazo, $this->tipoplazo);
        return Database::executeRow($sql, $params);
    }

    // Función para leer los países de origen
    public function leerRegistros()
    {
        $sql = 'SELECT idplazo, descripcion, vencimiento, plazo, tipoplazo
                FROM plazos INNER JOIN codigosplazos ON plazos.idcodigoplazo = codigosplazos.idcodigoplazo
                ORDER BY tipoplazo';
        return Database::getRows($sql);
    }

    // Función para seleccionar un pais de origen
    public function leerUnRegistro()
    {
        $sql = 'SELECT idplazo, descripcion, vencimiento, idcodigoplazo, tipoplazo
                FROM plazos
                WHERE idplazo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    // Actualizar pais de origen
    public function actualizarRegistro()
    {
        $sql = 'UPDATE plazos
                SET descripcion = ?, vencimiento = ?, idcodigoplazo = ?, tipoplazo = ?
                WHERE idplazo = ?';
        $params = array($this->descripcion, $this->vencimiento, $this->idcodigoplazo, $this->tipoplazo, $this->id);
        return Database::executeRow($sql, $params);
    }
    // Función para eliminar pais de origen
    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM plazos
                WHERE idplazo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
