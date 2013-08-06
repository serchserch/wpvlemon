<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Q\PvBundle\Resources\Lib\QuerySelect;

/**
 * @Route("/panel")
 * 
 */
class PanelController extends Controller
{
    
//    function __construct()
//    {
//        
//         if( ! $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
//            return $this->redirect($this->generateUrl('index_page'));
//        }
//        
//    }

    
    /**
     * @Route("/" , name="panel_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Template()
     */
    public function indexAction()
    {
        
       
        
        
        
        //$session = $this->getRequest()->getSession();
        //$session->set('tiendas', $tiendas);
        
        
                
        
        //select - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//        $sql = "SELECT * FROM tienda WHERE tienda.id = :id ;";
//        $tiendas = $conn->fetchAssoc($sql, array('id' => 1));
        

        //insert - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
//        $valores = array(
//            'id' => 7,
//            'nombre' => 'registro 7 7 7 ',
//        );
//        $conn->insert('tienda',$valores);
        
        
        // update - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
//        $conn->update('tienda', array('nombre' => 'valor cambiado'), array('id' => 3));
        
        
        // delete  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        //$conn->delete('tienda', array('id' => 3));
        
        
        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));
        
        // Tiendas
        $tiendas = $query->selectTiendasByIdUser($idUser);
        
        // Impuestos
        $impuestos = $query->selectImpuestosByIdUser($idUser);
        
        
        // Almacenes
        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        

        // Productos
        $productos = $query->selectProductosByIdUser($idUser);
                        
        $data = array(
            'impuestos' => $impuestos,
            'productos' => $productos,
            'almacenes' => $almacenes,
            'tiendas'   => $tiendas,
        );
        return $data;
    }

}
