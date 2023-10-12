<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CreditosFiscalesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipodepersona, razonsocial, empresa, email, direccion, pais, giro, categoria, telefono
        FROM creditosfiscales INNER JOIN paises USING(idpais)
                WHERE duinit LIKE ? OR tipodocumento LIKE ? OR tipodepersona LIKE ? OR razonsocial LIKE ? OR empresa LIKE ? OR email LIKE ? OR pais LIKE ? OR giro LIKE ? OR categoria LIKE ? OR telefono LIKE ?
                ORDER BY noregistro';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO creditosfiscales(noregistro, fecha, duinit, tipodocumento, tipodepersona, razonsocial, empresa, email, direccion, idpais, giro, categoria, telefono)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->noregistro, $this->fecha, $this->duinit, $this->tipodocumento, $this->tipodepersona, $this->razonsocial, $this->empresa, $this->email, $this->direccion, $this->idpais, $this->giro, $this->categoria, $this->telefono);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipodepersona, razonsocial, empresa, email, direccion, pais, giro, categoria, telefono
                FROM creditosfiscales INNER JOIN paises USING(idpais)
                ORDER BY noregistro';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipodepersona, razonsocial, empresa, email, direccion, idpais, giro, categoria, telefono
                FROM creditosfiscales
                WHERE idcreditofiscal = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE creditosfiscales
                SET noregistro = ?, fecha = ?, duinit = ?, tipodocumento = ?, tipodepersona = ?, razonsocial = ?, empresa = ?, email = ?, direccion = ?, idpais = ?, giro = ?, categoria = ?, telefono = ?
                WHERE idcreditofiscal = ?';
        $params = array($this->noregistro, $this->fecha, $this->duinit, $this->tipodocumento, $this->tipodepersona, $this->razonsocial, $this->empresa, $this->email, $this->direccion, $this->idpais, $this->giro, $this->categoria, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM creditosfiscales
                WHERE idcreditofiscal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerTipoDocumento()
    {
        $tipodoc = array(array('Dui','Dui'), array('Nit','Nit'), array('Otros o pasaporte','Otros o pasaporte'));
        return $tipodoc;
    }

    public function leerTipoPersona()
    {
        $tipopersona = array(array('Natural','Natural'), array('Juridico','Juridico'));
        return $tipopersona;
    }
}
