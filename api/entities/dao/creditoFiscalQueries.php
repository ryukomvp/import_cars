<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CreditoFiscalQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function buscarRegistros($value)
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipopersona, razonsocial, empresa, email, direccion, pais, giro, categoria, telefono
                FROM creditofiscal INNER JOIN paises USING(idpais)
                WHERE duinit LIKE ? OR tipodocumento LIKE ? OR tipopersona LIKE ? OR empresa LIKE ? OR email LIKE ? OR pais LIKE ? OR categoria LIKE ? OR telefono LIKE ?
                ORDER BY noregistro';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function crearRegistro()
    {
        $sql = 'INSERT INTO creditofiscal(noregistro, fecha, duinit, tipodocumento, tipopersona, razonsocial, empresa, email, direccion, idpais, giro, categoria, telefono)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->noregistro, $this->fecha, $this->duinit, $this->tipodocumento, $this->tipopersona, $this->razonsocial, $this->empresa, $this->email, $this->direccion, $this->idpais, $this->giro, $this->categoria, $this->telefono);
        return Database::executeRow($sql, $params);
    }

    public function leerRegistros()
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipopersona, razonsocial, empresa, email, direccion, pais, giro, categoria, telefono
                FROM creditofiscal INNER JOIN paises USING(idpais)
                ORDER BY correocontac';
        return Database::getRows($sql);
    }

    public function leerUnRegistro()
    {
        $sql = 'SELECT idcreditofiscal, noregistro, fecha, duinit, tipodocumento, tipopersona, razonsocial, empresa, email, direccion, idpais, giro, categoria, telefono
                FROM creditofiscal
                WHERE idcreditofiscal = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarRegistro()
    {
        $sql = 'UPDATE creditofiscal
                SET noregistro = ?, fecha = ?, duinit = ?, tipodocumento = ?, tipopersona = ?, razonsocial = ?, empresa = ?, email = ?, direccion = ?, idpais = ?, giro = ?, categoria = ?, telefono = ?
                WHERE idcreditofiscal = ?';
        $params = array($this->noregistro, $this->fecha, $this->duinit, $this->tipodocumento, $this->tipopersona, $this->razonsocial, $this->empresa, $this->email, $this->direccion, $this->idpais, $this->giro, $this->categoria, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function eliminarRegistro()
    {
        $sql = 'DELETE FROM creditofiscal
                WHERE idcreditofiscal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function leerTipoDocumento()
    {
        $estados = array(array('DUI','DUI'), array('NIT','NIT'));
        return $estados;
    }

    public function leerTipoPersona()
    {
        $estados = array(array('Natural','Natural'), array('Juridico','Juridico'));
        return $estados;
    }
}
