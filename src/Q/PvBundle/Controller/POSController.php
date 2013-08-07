<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Q\PvBundle\Resources\Lib\QuerySelect;
use Q\PvBundle\Entity\Venta;


use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/pos")
 * 
 */
class POSController extends Controller
{

    /**
     * @Route("/{id_tienda}t" , name="pos_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Template()
     */
    public function indexAction($id_tienda)
    {
        if (!$id_tienda or (!is_numeric($id_tienda))){
            return $this->redirect($this->generateUrl('panel_index'));
        }
        
        $session = $this->getRequest()->getSession();
        $control = hash('sha512', sha1(rand()));
        $session->set('control', $control);
        
        $em = $this->getDoctrine()->getManager();
        
        /**
         * @todo AplicarSeguridad
         */
        $tienda = $em->getRepository('QPvBundle:Tienda')->findOneById($id_tienda);
        
        return array(
            'tienda' => $tienda,
            'control' => $control,
        );
    }

    /**
     * 
     * Se obtiene el artículo de la tienda, y regresa 
     * 
     * @Route("/product_action", name="producto_info")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function ajaxAction()
    {

        $query = $this->getRequest()->request->get('query');




        $select = new QuerySelect($this->get('database_connection'));
        $producto = array();

        $producto = $select->productoCodigoDeBarras($query, $this->getUser()->getId());

        if (empty($producto)) {
            $producto = $select->productoSku($query, $this->getUser()->getId());
        }

        if (!empty($producto)) {
            $articulo = array(
                'qery' => $query,
                'id' => $producto['id'],
                'sku' => $producto['sku'],
                'barcode' => $producto['codigo_de_barras'],
                'preciomayoreo' => $producto['precio_mayoreo'],
                'cantidadmayoreo' => $producto['cantidad_mayoreo'],
                'nombre' => $producto['nombre'],
                'precioventa' => $producto['precio_venta'],
                'descripcion' => $producto['descripcion'],
                'imagen' => $producto['imagen'],
            );
        } else {
            $articulo = array(
                'error' => true,
            );
        }
        return new Response(json_encode($articulo));
    }

    /**
     * 
     * @Route("/venta_terminada", name="venta_terminada")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Template()
     */
    public function ventaTerminadaAction()
    {



        // para que solamente una session al mismo tiempo *
        $session = $this->getRequest()->getSession();
        $control_k = $session->get('control');

        // generamos el numero de venta


        $control_f = $this->getRequest()->request->get('control');

        if ($control_k != $control_f)
            echo "No es igual";

        $parametros = $this->getRequest()->request->get('json_in');
        $cantidades = json_decode($parametros, true);
        $articulos = array();



        // acomodamos los artículos por ID y cantidades *
        // respecto a base de datos, así no obtenemos *
        // duplicados*
        foreach ($cantidades as $qt) {
            $id = $qt['id'];
            $cantidad = $qt['qt'];
            if (!isset($articulos[$id])) {
                $articulos[$id] = $cantidad;
            } else {
                $articulos[$id] += $cantidad;
            }
        }


        $em = $this->getDoctrine()->getManager();
        $producto = new \Q\PvBundle\Entity\Producto();
        
        
        $tienda = $em->getRepository('QPvBundle:Tienda')
                ->findOneById($this->getRequest()->request->get('tienda'));


        $productos_comprados = array();
        $impuesto_total = 0;
        $total = 0;
        $total_articulos = 0;
        $descuento_total = 0;


        // Salvamos la cantidad de artículos vendidos 
        // Descontamos la cantidad de artículos del almacén *



        foreach ($articulos as $id => $cantidad) {

            $subtotal = 0;

            $producto = $em->getRepository('QPvBundle:Productos')->findOneById($id);

            $descuento = 0;

            $c_mayoreo = $producto->getCantidadMayoreo();
            if ($cantidad >= $c_mayoreo) {
                $subtotal = $cantidad * $producto->getPrecioMayoreo();
                $precio_vendido = $producto->getPrecioMayoreo();
                $descuento = ($producto->getPrecioVenta() - $producto->getPrecioMayoreo()) * $cantidad;
            } else {
                $subtotal = $cantidad * $producto->getPrecioVenta();
                $precio_vendido = $producto->getPrecioVenta();
            }

            $impuesto = $em->getRepository('QPvBundle:Impuesto')->findOneById($producto->getImpuestoId());

            $ratio = $impuesto->getPorcentaje() / 100;

            $impuesto = $subtotal * $ratio;





            $total_articulos += $cantidad;
            $total += $subtotal;
            $impuesto_total += $impuesto;
            $descuento_total += $descuento;


            // descontar la cantidad del total de articulos vendidos del almacén * 
            $producto->setCantidadActual($producto->getCantidadActual() - $cantidad);



            if ($producto->getCantidadActual() >= $producto->getCantidadMinima()) {
                //MAndamos aviso
            }

            $inventario = $producto->getCantidadActual();

            $em->persist($producto);
            $em->flush();

            // si los artículos restantes son menos del límite
            // mandamos aviso.

            $productos_comprados[] = array(
                'id' => $producto->getId(),
                'codigo_de_barras' => $producto->getCodigoDeBarras(),
                'sku' => $producto->getSku(),
                'cantidad' => $cantidad,
                'impuesto' => $impuesto,
                'nombre' => $producto->getNombre(),
                'precio_compra' => $producto->getPrecioCompra(),
                'precio_venta' => $producto->getPrecioVenta(),
                'precio_mayoreo' => $producto->getPrecioMayoreo(),
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'inventario' => $inventario,
                'cantidad_minima' => $producto->getCantidadMinima(),
                'precio_vendido' => $precio_vendido,
            );
        }

        // Obtenemos el los artículos de la base de datos  *
        // y aplicamos los descuentos del cliente *
        // Mostramos el total *
        // Mostramos el Impuesto *
        //Insertamos la venta en la base de datos

        $venta = new Venta();

        $venta->setCodigo(str_replace('.', '', microtime(true)));
        $venta->setFecha(new \DateTime('now'));
        $venta->setTotalSinImpuesto($total - $impuesto_total);
        $venta->setTotalConImpuesto($total);
        $venta->setUserId($this->getUser()->getId());
        $venta->setNoProductosVendidos(count($articulos));
        $venta->setNoArticulosVendidos($total_articulos);
        $venta->setProductosVendidos(json_encode($productos_comprados));
        $venta->setTienda_id($tienda->getId());
        //print_r($venta);
        $em->persist($venta);
        $em->flush();

        $venta_id = $venta->getId();
       
        foreach ($productos_comprados as $prod) {
           // $prod['id'] , $prod['cantidad'],
        }

        $data = array(
            'tienda' => $tienda,
            'venta_id' => $venta->getId(),
            'codigo_venta' => $venta->getCodigo(),
            'productos_comprados' => $productos_comprados,
            'descuento_total' => $descuento_total,
            'total_sin_impuesto' => $total - $impuesto_total,
            'impuesto' => $impuesto_total,
            'total' => $total,
            'total_articulos_iguales' => count($articulos),
            'total_articulos' => $total_articulos,
        );

        return $data;
    }

    /**
     * Se regresa una lista de los posibles artículos que el usuario escribe
     * 
     * No implementada
     * 
     * @Route("/producto_nombre_action", name="posibles_productos")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function ajaxProducto()
    {

        // lo que manda el usuario
        $request = $this->container->get('request');
        $nombre = $request->request->get('producto');

        $select = new QuerySelect($this->get('database_connection'));
        $producto = array();

        $productos = $select->productosPorNombre($nombre, $this->getUser()->getId());

        return new Response(json_encode($json));
    }

    /**
     * @Route("/ticket/", defaults={"ticket" = 0})
     * @Route("/ticket/{ticket}" , name="ticket")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method({"GET"})
     */
    public function ticketAction($ticket)
    {
        // si no hay ticket o si no es numerico 
        if (
                !$ticket or !is_numeric($ticket)
        ) {
            return $this->redirect($this->generateUrl('index_page'));
        }

        //$venta = new Venta();
        $em = $this->getDoctrine()->getManager();
        $venta = $em->getRepository('QPvBundle:Venta')->findOneById($ticket);
        $tienda= $em->getRepository('QPvBundle:tienda')->findOneById($venta->getTienda_id());

        // Si no existe en la base de datos
        if (!$venta) {
            return $this->redirect($this->generateUrl('index_page'));
        }

        $articulos = json_decode($venta->getProductosVendidos(), true);

        //print_r($articulos);

        /*         * ************************* */
        $borde = 0;
        //$tienda = new \Q\PvBundle\Entity\Tienda();
        //$venta = new Venta();
        /*         * ************************* */

        $pdf = new \fpdf\FPDF;
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 6);

        // Cabecera  del ticket
        // Logo 
        //$pdf->Image('D:/fotos/lemon.jpg', 10, 10, 32, 16);
        $pdf->Cell(0, 6, $tienda->getNombre()  , $borde, 1);

        $pdf->Cell(0, 6, "Venta al publico" , $borde, 1);
        
        
        $fecha = "Fecha: " . $venta->getFecha()->format('d / m / Y  h:i:s a');
        $pdf->Cell(0, 6, $fecha , $borde, 1);



//        $pdf->SetFont('Helvetica', '', 10);
//        $direccion = "Calle ayuntamiento No 20, local H, Atizapán de Zaragoza, Estado de México";
//        $pdf->Cell(0, 6, $direccion, $borde, 1, 'L');
        // Nombre de la tienda
        // Disclaimer
        $disclaimer = "Éste comprobante no tiene valor fiscal";
        $pdf->Cell(0, 6, $disclaimer, $borde, 1, 'L');


        //  / /Nombre del cliente
        // Nombre del tendero

        $tendero = "Te atendió: " . $this->getUser()->getNombre();
        $pdf->Cell(0, 6, $tendero, $borde, 1, 'L');

        $pdf->Ln();
        
        // Numero de venta

        $vnt = "Numero de Venta:" . $venta->getCodigo();
        $pdf->Cell(0, 6, $vnt , $borde, 1, 'L');

        // Numero de operación
        $operacion = "Numero de operación:" . $venta->getId();
        $pdf->Cell(0, 6, $operacion , $borde, 1, 'L');

        $pdf->Ln();
        

        // Artculos vendidos
        //  Cantidad - Nombre - P.Unitario - Importe

        $a = "Cantidad - Nombre - PrecioUnitario - Importe";
        $pdf->Cell(15, 6, 'Cantidad', $borde, 0, 'L');
        $pdf->Cell(30, 6, 'Nombre ', $borde, 0, 'L');
        $pdf->Cell(30, 6, 'Precio Unitario', $borde, 0, 'L');
        $pdf->Cell(30, 6, 'Importe', $borde, 1, 'L');
        $pdf->Cell(120, 0, '', 'B', 1);
        



        foreach ($articulos as $ar) {
            $pdf->Cell(15, 6, $ar['cantidad'] , $borde, 0, 'L');
            $pdf->Cell(30, 6, $ar['nombre'] , $borde, 0, 'L');
            $pdf->Cell(30, 6, '$ ' . $ar['precio_vendido'], $borde, 0, 'L');
            $pdf->Cell(30, 6, '$ ' . $ar['subtotal'], $borde, 1, 'L');
        }
        
        $pdf->Ln();


        // Subtotal
        $subtotal = "Subtotal : \$" . $venta->getTotalSinImpuesto();
        $pdf->Cell(0, 6, $subtotal, $borde, 1, 'L');
        // Impuesto 
        $impuesto = "Impuesto : \$" . ($venta->getTotalConImpuesto() - $venta->getTotalSinImpuesto());
        $pdf->Cell(0, 6, $impuesto , $borde, 1, 'L');

        // Total
        $total = "Total : \$" . $venta->getTotalConImpuesto();
        $pdf->Cell(0, 6, $total , $borde, 1, 'L');


        // Efectivo
        // Direccion de la tienda (aviso del ticket)

//        $aviso = "En Lemon solutions estamos para ayudarte, sigue particpando"
//                . " para ganar uno de los 3 iphones,  o una de las 10 tabletas"
//                . " que rifamos en éstos tiempos de pascua  y de felicidad.   "
//                . "y que creemos que te mereces, por ser nuestro cliente. Todo"
//                . " lo anterior es solo si compras mas de $20,000 (veinte mil pesos).";
//
//        $pdf->MultiCell(0, 5, $aviso, $borde, 1);



        return new Response($pdf->Output(), 200, array(
            'Content-type' => 'application/pdf',
        ));
    }

    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction()
    {
        return array();
    }

}
