<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Resources\Lib\QuerySelect;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/r")
 */
class ReportesController extends Controller
{

    /**
     * @Route("/" , name="reportes_index")
     * @Template()
     */
    public function indexAction()
    {
        
        $user_id = $this->getUser()->getId();
        $select = new QuerySelect($this->get('database_connection'));
        $date = new \DateTime('now');
        $hoy = $select->estadisticasDia($user_id, $date);
        
        //print_r($hoy);
        
        $total_vendido = 0;
        $prodcutos_vendidos = 0;
        
        
        
        foreach ($hoy as $ventas) {
            $total_vendido += $ventas['total_con_impuesto'];
            $prodcutos_vendidos += $ventas['no_productos_vendidos'];
        }
        
        
        
        return array(
            'total_vendido' => $total_vendido,
            'prodcutos_vendidos' => $prodcutos_vendidos,
            'ventas' => $hoy,
        );
    }
    
    /**
     * @Route("/diad" , name="reporte_dia_d")
     * 
     */
    public function diadeAction()
    {
        
        $year = $this->getRequest()->request->get('year');
        $month = $this->getRequest()->request->get('month');
        $day = $this->getRequest()->request->get('day');
        $tienda_id = $this->getRequest()->request->get('tienda');
        
        $select = new QuerySelect($this->get('database_connection'));
        $date = new \DateTime();
        $date->setDate($year, $month, $day);
        
        if (!is_numeric($tienda_id)){
            return new Response(json_encode('.i.'));
        }
        
        if($tienda_id == 0){
            $ventas_del_dia = $select->estadisticasDia($this->getUser()->getId(), $date);
        } else {
            $ventas_del_dia = $select->estadisticasDiaTienda($this->getUser()->getId(), $date, $tienda_id);
        }
        
        $prodcutos_vendidos = 0;
        $total_vendido = 0;
        foreach ($ventas_del_dia as $venta) {
            $total_vendido += $venta['total_con_impuesto'];
            $prodcutos_vendidos += $venta['no_articulos_vendidos'];
        }
        
        $data = array(
            'articulos_vendidos' => $prodcutos_vendidos,
            'total_vendido' => $total_vendido,
            'ventas_del_dia' => $ventas_del_dia,
            
        );
        
        return new Response(json_encode($data));
    }

    
    /**
     * @Route("/diario" , name="reporte_diario")
     * @Template()
     */
    public function diarioAction()
    {
        
        $select = new QuerySelect($this->get('database_connection'));
        $tiendas = $select->selectTiendasByIdUser($this->getUser()->getId());
        
        /**
         * @todo Si solo existe una tienda hacemos el ruteo.
         */
        
        return array(
            'min' => $this->getUser()->getFechaCreacion(),
            'tiendas' => $tiendas
        );
        
        
    }

    /**
     * @Route("/semanal" , name="reporte_semanal")
     * @Template()
     */
    public function semanalAction()
    {
        return array();
    }

    /**
     * @Route("/mensual" , name="reporte_mensual")
     * @Template()
     */
    public function mensualAction()
    {
        $meses = array( 
           'Enero',
           'Febrero',
           'Marzo',
           'Abril',
           'Mayo',
           'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
            );
        
        $select = new QuerySelect($this->get('database_connection'));
        $tiendas = $select->selectTiendasByIdUser($this->getUser()->getId());
        
        
        return array(
            'meses' => $meses,
            'min' => $this->getUser()->getFechaCreacion(),
            'tiendas' => $tiendas
        );
    }

    /**
     * @Route("/anual" , name="reporte_anual")
     * @Template()
     */
    public function anualAction()
    {
        return array();
    }

    /**
     * @Route("/fechas")
     * @Template()
     */
    public function fechasAction()
    {
        return array();
    }

    /**
     * @Route("mas-vendido" , name="reporte_masvendido")
     * @Template()
     */
    public function masVendidoAction()
    {
        return array();
    }

    /**
     * @Route("menos-vendido" , name="reporte_menosvendido")
     * @Template()
     */
    public function menosVendidoAction()
    {
        return array();
    }

}
