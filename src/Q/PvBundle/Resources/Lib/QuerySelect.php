<?php

namespace Q\PvBundle\Resources\Lib;

/**
 * Description of Query
 *
 * @author Isaac
 */
class QuerySelect
{

    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    
    /**
     * Regresa todos los impuestos que tiene agregado un  usuario
     * 
     * @param type $id del usuario
     * @return array impuestos
     */
    public function selectImpuestosByIdUser( $idUser )
    {
        $sql = "SELECT impuesto.* FROM user_has_impuesto
                INNER JOIN impuesto on user_has_impuesto.impuesto_id = impuesto.id
                WHERE user_has_impuesto.user_id = :id
                AND
                impuesto.activo = true";
        return $this->conn->fetchAll($sql, array('id' => $idUser));
    }
    
    /**
     * Regresa todas las tiendas que tiene un usuario
     * 
     * @param type $idUser
     * @return type
     */
    public function selectTiendasByIdUser( $idUser )
    {
        $sql = "SELECT tienda.* FROM user_has_tienda
                INNER JOIN tienda ON user_has_tienda.tienda_id = tienda.id
                WHERE user_has_tienda.user_id = :id 
                AND
                tienda.activa = true ";
        return $this->conn->fetchAll($sql, array('id' => $idUser));
        
    }
    
    /**
     * Regresa todos los almacenes de todas las tiendas que tiene un uauario
     * @param type $idUser
     * @return type
     */
    public function selectAlmacenesByIdUser( $idUser )
    {
        
        $sql = "SELECT almacen.* FROM user_has_almacen
                INNER JOIN almacen ON user_has_almacen.almacen_id = almacen.id
                WHERE user_has_almacen.user_id = :id
                AND
                almacen.activo = true";
        
        return $this->conn->fetchAll($sql, array('id' => $idUser));
        
    }
    
    public function selectProductosByIdUser( $idUser )
    {
        $sql = "SELECT productos.* FROM user_has_producto
                INNER JOIN productos ON productos.id = user_has_producto.producto_id
                WHERE user_has_producto.user_id = :id 
                ORDER BY fecha_creacion DESC ";
        
        return $this->conn->fetchAll($sql, array('id' => $idUser));
    }
    
    
    /**
     * 
     * @param type $idUser
     * @todo Limpiar query
     */
    public function productosCByUser( $idUser )
    {
        $sql =  "SELECT
                producto.id,
                producto.nombre,
                producto.descripcion,
                producto.fecha_creacion,
                producto.fecha_modificacion,
                producto.codigo_de_barras,
                almacen_has_producto.almacen_id,
                almacen_has_producto.producto_id,
                almacen_has_producto.impuesto_id,
                almacen_has_producto.precio_compra,
                almacen_has_producto.precio_venta,
                almacen_has_producto.precio_mayoreo,
                almacen_has_producto.cantidad_para_mayoreo,
                almacen_has_producto.cantidad_minima,
                almacen_has_producto.cantidad_actual,
                almacen_has_producto.agotado,
                almacen_has_producto.disponible,
                almacen_has_producto.activo,
                almacen_has_producto.codigo_proveedor,
                almacen_has_producto.sku,
                almacen_has_producto.codigo_de_venta,
                almacen_has_producto.codigo_de_compra,
                almacen.nombre AS almacen_nombre
                FROM user_has_producto
                INNER JOIN producto ON user_has_producto.producto_id = producto.id
                INNER JOIN almacen_has_producto ON almacen_has_producto.producto_id = producto.id
                INNER JOIN almacen ON almacen.id = almacen_has_producto.almacen_id
                WHERE user_has_producto.user_id = :id
                AND almacen_has_producto.activo = TRUE ";
        
        return $this->conn->fetchAll($sql, array('id' => $idUser));
        
    }
    
    
    public function ProductoByIdProductoAlmacen( $productoId , $almacenId )
    {
        $sql = "SELECT
                producto.id,
                producto.nombre,
                producto.descripcion,
                producto.fecha_creacion,
                producto.fecha_modificacion,
                producto.codigo_de_barras,
                almacen_has_producto.almacen_id,
                almacen_has_producto.producto_id,
                almacen_has_producto.impuesto_id,
                almacen_has_producto.precio_compra,
                almacen_has_producto.precio_venta,
                almacen_has_producto.precio_mayoreo,
                almacen_has_producto.cantidad_para_mayoreo,
                almacen_has_producto.cantidad_minima,
                almacen_has_producto.cantidad_actual,
                almacen_has_producto.agotado,
                almacen_has_producto.disponible,
                almacen_has_producto.activo,
                almacen_has_producto.codigo_proveedor,
                almacen_has_producto.sku,
                almacen_has_producto.codigo_de_venta,
                almacen_has_producto.codigo_de_compra
                FROM producto
                INNER JOIN almacen_has_producto ON almacen_has_producto.producto_id = producto.id
                WHERE
                almacen_has_producto.almacen_id = :almacen_id
                AND
                almacen_has_producto.producto_id = :producto_id ";
        
        $s = array(
            'almacen_id' => $almacenId,
            'producto_id' => $productoId
        );
        return $this->conn->fetchAssoc($sql, $s );
    }
    
    
    public function productoCodigoDeBarras($producto,$user_id)
    {
        $sql = "SELECT productos.* FROM productos
                INNER JOIN user_has_producto ON user_has_producto.producto_id = productos.id
                WHERE productos.codigo_de_barras = :codigo_de_barras
                AND
                user_has_producto.user_id = :user_id
                LIMIT 1";
        
        $s = array(
            'codigo_de_barras' => $producto,
            'user_id' => $user_id,
        );
        
        return $this->conn->fetchAssoc($sql, $s );
    }
    
    
    public function productoSku($producto,$user_id)
    {
        $sql = "SELECT productos.* FROM productos
                INNER JOIN user_has_producto ON user_has_producto.producto_id = productos.id
                WHERE productos.sku = :sku
                AND
                user_has_producto.user_id = :user_id
                LIMIT 1";
        
        $s = array(
            'sku' => $producto,
            'user_id' => $user_id,
        );
        
        return $this->conn->fetchAssoc($sql, $s );
    }
    
    
    public function estadisticasDia($user_id, $date)
    {
        
        
        
        $day = $date->format('Y-m-d');
        
        $sql =  "SELECT 
                venta.id,
                venta.codigo,
                venta.fecha,
                venta.total_sin_impuesto,
                venta.total_con_impuesto,
                venta.user_id,
                venta.no_productos_vendidos,
                venta.no_articulos_vendidos,
                venta.tienda_id
                FROM venta WHERE 
                DATE(venta.fecha) = DATE('{$day}')
                AND
                venta.user_id = :user_id ";
        
        $s = array(
            'user_id' => $user_id,
        );
        return $this->conn->fetchAll($sql, $s );
    }
    
    
    public function estadisticasDiaTienda($user_id, $date, $tienda_id)
    {
        
        $day = $date->format('Y-m-d');
        
        $sql =  "SELECT 
                venta.id,
                venta.codigo,
                venta.fecha,
                venta.total_sin_impuesto,
                venta.total_con_impuesto,
                venta.user_id,
                venta.no_productos_vendidos,
                venta.no_articulos_vendidos,
                venta.tienda_id
                FROM venta WHERE 
                DATE(venta.fecha) = DATE('{$day}')
                AND
                venta.user_id = :user_id 
                AND
                venta.tienda_id = :tienda_id";
        
        $s = array(
            'user_id' => $user_id,
            'tienda_id' => $tienda_id
        );
        
        return $this->conn->fetchAll($sql, $s );
    }
    

}