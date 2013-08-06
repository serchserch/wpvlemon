<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\Producto;
use Q\PvBundle\Form\ProductoType;
use Q\PvBundle\Resources\Lib\QuerySelect;
use Q\PvBundle\Resources\Lib\QueryInsert;
use Q\PvBundle\Resources\Lib\QueryUpdate;


use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Producto controller.
 *
 * @Route("/panel/producto")
 */
class ProductoController extends Controller
{

    /**
     * Lists all Producto entities.
     *
     * @Route("/", name="producto_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {


        $select = new QuerySelect($this->get('database_connection'));

        $productos = $select->productosCByUser($this->getUser()->getId());

        return array(
            'entities' => $productos,
        );
    }

    /**
     * Creates a new Producto entity.
     *
     * @Route("/", name="producto_create")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("POST")
     * @Template("QPvBundle:Producto:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );

        $form = $this->createForm(new ProductoType($data));
        $form->bind($request);
        if ($form->isValid()) {
            $datos = $request->request->get('producto');



            $insert = new QueryInsert($this->get('database_connection'));
            $insert->insertProducto($datos, $this->getUser()->getId());
            return $this->redirect($this->generateUrl('producto_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     * @Route("/new", name="producto_new")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);


        /**
         * @todo Guardar en sesion, las últimas selecciones de almacen e 
         *       impuesto, para que el usuario no tenga que seleccionarlas 
         *      todo el tiempo
         */
        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );

        $entity = new Producto();
        $form = $this->createForm(new ProductoType($data));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Producto entity.
     *
     * @Route("/{id}/{almacen}", name="producto_show")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $almacen)
    {


        $select = new QuerySelect($this->get('database_connection'));


        $entity = $select->ProductoByIdProductoAlmacen($id, $almacen);
        print_r($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     * @Route("/{id}/{almacen}/edit", name="producto_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $almacen)
    {


        // obtenemos el producto completo 
        $query = new QuerySelect($this->get('database_connection'));
        $entity = $query->ProductoByIdProductoAlmacen($id, $almacen);

        // si no hay producto se tira el error
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        // se hace una instancia manual del producto
        // y se setean los valores
        $p = new Producto;
        $p->setCodigoDeBarras($entity['codigo_de_barras']);
        $p->setSku($entity['sku']);
        $p->setNombre($entity['nombre']);
        $p->setDescripcion($entity['descripcion']);
        $p->setAlmacen($entity['almacen_id']);
        $p->setImpuesto($entity['impuesto_id']);
        $p->setPrecioCompra($entity['precio_compra']);
        $p->setPrecioVenta($entity['precio_venta']);
        $p->setPrecioMayoreo($entity['precio_mayoreo']);
        $p->setCantidadParaMayoreo($entity['cantidad_para_mayoreo']);
        $p->setCantidadMinima($entity['cantidad_minima']);
        $p->setCantidadActual($entity['cantidad_actual']);
        $p->setDisponible($entity['disponible']);
        $p->setCodigoProveedor($entity['codigo_proveedor']);
        $p->setCodigoDeVenta($entity['codigo_de_venta']);
        $p->setCodigoDeCompra($entity['codigo_de_compra']);






        // seleccionamos los lmacenes del usuario 
        // y los impuestos
        $idUser = $this->getUser()->getId();
        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );

        // creamos un formulario con los almacenes y los impuestos
        // y seteamos los valores iniciales , (los que ya estaban guardados
        // en la base de datos)
        $editForm = $this->createForm(new ProductoType($data), $p);
        $deleteForm = $this->createDeleteForm($id);

        // regresamos el formulario ya armado.
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Producto entity.
     *
     * @Route("/u/{id}/{almacen}", name="producto_update")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("PUT")
     * @Template("QPvBundle:Producto:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $almacen)
    {
        
        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );

        $form = $this->createForm(new ProductoType($data));
        $form->bind($request);

        if ($form->isValid()) {

            $datos = $request->request->get('producto');


            $update = new QueryUpdate($this->get('database_connection'));
            
            $update->productosCompletos($datos, $almacen, $id);

            return $this->redirect($this->generateUrl('producto_index'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Producto entity.
     *
     * @Route("/{id}", name="producto_delete")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:Producto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('producto_index'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
