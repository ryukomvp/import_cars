<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class VendedorQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idvendedor, nombreus, nombrecaja
                FROM vendedores INNER JOIN cajas USING(idcaja) INNER JOIN usuarios USING(idusuario)
                WHERE nombreus LIKE ? OR nombrecaja LIKE ?
                ORDER BY nombrecaja';
        $params = array("%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO vendedores(idusuario, idcaja)
                VALUES(?,?)';
        $params = array($this->idusuario, $this->idcaja);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idvendedor, nombreus, nombrecaja
                FROM vendedores INNER JOIN cajas ON vendedores.idcaja = cajas.idcaja INNER JOIN usuarios ON vendedores.idusuario = usuarios.idusuario
                ORDER BY nombrecaja';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idvendedor, idusuario, idcaja
                FROM vendedores
                WHERE idvendedor = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE vendedores
                SET idusuario = ?, idcaja = ?
                WHERE idvendedor = ?';
        $params = array($this->idusuario, $this->idcaja, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM vendedores
                WHERE idvendedor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
