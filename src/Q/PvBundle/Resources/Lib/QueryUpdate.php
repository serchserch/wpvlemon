<?php

namespace Q\PvBundle\Resources\Lib;

class QueryUpdate
{

    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function productosCompletos($data, $almacen_id, $producto_id )
    {
                // Hacemos dos querys en la misma sentencia.
        $sql = "START TRANSACTION; 
            
                UPDATE producto
                SET
                nombre = :nombre ,
                descripcion = :descripcion ,
                fecha_modificacion = CURRENT_TIMESTAMP ,
                codigo_de_barras = :codigo_de_barras 
                WHERE producto.id = :idProducto ;
                
                UPDATE almacen_has_producto
                SET
                almacen_id = :almacen_id ,
                producto_id = :producto_id ,
                impuesto_id = :impuesto_id ,
                precio_compra = :precio_compra ,
                precio_venta = :precio_venta ,
                precio_mayoreo = :precio_mayoreo ,
                cantidad_para_mayoreo = :cantidad_para_mayoreo ,
                cantidad_minima = :cantidad_minima ,
                cantidad_actual = :cantidad_actual ,
                disponible = :disponible ,
                codigo_proveedor = :codigo_proveedor ,
                sku = :sku ,
                codigo_de_venta = :codigo_de_venta ,
                codigo_de_compra = :codigo_de_compra 
                WHERE
                almacen_has_producto.almacen_id = :idAlmacen
                AND
                almacen_has_producto.producto_id = :idProducto;
                
                COMMIT;";


        $st = $this->conn->prepare($sql);

        // Tabla de producto
        $st->bindValue("nombre", $data['nombre'], \PDO::PARAM_STR);
        $st->bindValue("descripcion", $data['descripcion'], \PDO::PARAM_STR);
        $st->bindValue("codigo_de_barras", $data['codigoDeBarras'], \PDO::PARAM_STR);
        $st->bindValue("idProducto", $producto_id , \PDO::PARAM_INT);
        
        //Tabla de almacen_has_prodcuto
        $st->bindValue("almacen_id", $data['almacen'], \PDO::PARAM_INT);
        $st->bindValue("producto_id", $producto_id , \PDO::PARAM_INT);
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
        $st->bindValue("idAlmacen", $almacen_id , \PDO::PARAM_STR);
        $st->bindValue("idProducto", $producto_id , \PDO::PARAM_STR);
        
        $st->execute();
        
    }

}

?>
