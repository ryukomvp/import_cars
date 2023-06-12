<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ProductQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto INNER JOIN categoria USING(id_categoria)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ? OR categoria ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        // , $_SESSION['id_usuario_privado']
        $sql = 'INSERT INTO producto(nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->codigo, $this->dimensiones, $this->categoria, $this->material, $this->proveedor, $this->estado, $this->existencia);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto INNER JOIN categoria USING(id_categoria)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE producto
                SET nombre_producto = ?, foto =?,descripcion_producto = ?, precio_producto =?, codigo_producto = ?, dimensiones = ?, id_categoria = ?, id_tipo_material = ?, id_proveedor = ?, estado = ?, cantidad_existencias = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->precio, $this->codigo, $this->dimensiones, $this->categoria, $this->material, $this->proveedor, $this->estado,  $this->existencia, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readproductoCategoria()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto,  descripcion_producto, precio_producto
                FROM producto INNER JOIN categoria USING(id_categoria)
                WHERE id_categoria = ? AND estado = true
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */
    // public function productoCategoria()
    // {
    //     $sql = 'SELECT nombre_producto, precio_producto, estado_producto
    //             FROM producto INNER JOIN categorias USING(id_categoria)
    //             WHERE id_categoria = ?
    //             ORDER BY nombre_producto';
    //     $params = array($this->categoria);
    //     return Database::getRows($sql, $params);
    // }
}
