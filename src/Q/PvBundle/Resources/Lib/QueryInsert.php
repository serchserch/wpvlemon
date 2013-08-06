<?php

namespace Q\PvBundle\Resources\Lib;

/**
 * Description of Query
 *
 * @author Isaac
 */
class QueryInsert
{

    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertProducto($data,$userId)
    {
        
        // Hacemos dos querys en la misma sentencia.
        $sql = "START TRANSACTION;
                INSERT INTO producto (
                nombre ,
                descripcion ,
                fecha_creacion ,
                fecha_modificacion ,
                codigo_de_barras 
                )
                VALUES (
                :nombre ,
                :descripcion ,
                CURRENT_TIMESTAMP ,
                CURRENT_TIMESTAMP ,
                :codigo_de_barras 
                );
                INSERT INTO almacen_has_producto (
                almacen_id ,
                producto_id ,
                impuesto_id ,
                precio_compra ,
                precio_venta ,
                precio_mayoreo ,
                cantidad_para_mayoreo ,
                cantidad_minima ,
                cantidad_actual ,
                agotado ,
                disponible ,
                activo ,
                codigo_proveedor ,
                sku ,
                codigo_de_venta ,
                codigo_de_compra 
                )
                VALUES ( 
                :almacen_id ,
                LAST_INSERT_ID() ,
                :impuesto_id ,
                :precio_compra ,
                :precio_venta ,
                :precio_mayoreo ,
                :cantidad_para_mayoreo ,
                :cantidad_minima ,
                :cantidad_actual ,
                FALSE ,
                :disponible ,
                TRUE ,
                :codigo_proveedor,
                :sku ,
                :codigo_de_venta ,
                :codigo_de_compra 
                );
                INSERT INTO user_has_producto(
                user_id ,
                producto_id
                )
                VALUES (
                :user_id ,
                LAST_INSERT_ID()
                );
                COMMIT;";


        $st = $this->conn->prepare($sql);

        // Tabla de producto
        $st->bindValue("nombre", $data['nombre'], \PDO::PARAM_STR);
        $st->bindValue("descripcion", $data['descripcion'], \PDO::PARAM_STR);
        $st->bindValue("codigo_de_barras", $data['codigoDeBarras'], \PDO::PARAM_STR);

        //Tabla de almacen_has_prodcuto
        $st->bindValue("almacen_id", $data['almacen'], \PDO::PARAM_INT);
        $st->bindValue("impuesto_id", $data['impuesto'], \PDO::PARAM_INT);
        $st->bindValue("precio_compra", $data['precioCompra'], \PDO::PARAM_STR);
        $st->bindValue("precio_venta", $data['precioVenta'], \PDO::PARAM_STR);
        $st->bindValue("precio_mayoreo", $data['precioMayoreo'], \PDO::PARAM_STR);
        $st->bindValue("cantidad_para_mayoreo", $data['cantidadParaMayoreo'], \PDO::PARAM_STR);
        $st->bindValue("cantidad_minima", $data['cantidadMinima'], \PDO::PARAM_STR);
        $st->bindValue("cantidad_actual", $data['cantidadActual'], \PDO::PARAM_STR);
        $st->bindValue("disponible", $data['disponible'], \PDO::PARAM_BOOL);
        $st->bindValue("codigo_proveedor", $data['codigoProveedor'], \PDO::PARAM_STR);
        $st->bindValue("sku", $data['sku'], \PDO::PARAM_STR);
        $st->bindValue("codigo_de_venta", $data['codigoDeVenta'], \PDO::PARAM_STR);
        $st->bindValue("codigo_de_compra", $data['codigoDeCompra'], \PDO::PARAM_STR);
        
        
        // tabla de usuario tiene productos
        $st->bindValue("user_id", $userId, \PDO::PARAM_STR);
        
        $st->execute();
        
        
    }

}