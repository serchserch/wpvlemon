<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\Productos;
use Q\PvBundle\Form\ProductosType;
use Q\PvBundle\Resources\Lib\QuerySelect;


use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Productos controller.
 *
 * @Route("panel/productos")
 */
class ProductosController extends Controller
{

    /**
     * Lists all Productos entities.
     *
     * @Route("/", name="productos")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        // Productos
        $productos = $query->selectProductosByIdUser($idUser);

        //$em = $this->getDoctrine()->getManager();
        //$productos = $em->getRepository('QPvBundle:Productos')->findAll();

        return array(
            'entities' => $productos,
        );
    }

    /**
     * Creates a new Productos entity.
     *
     * @Route("/", name="productos_create")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("POST")
     * @Template("QPvBundle:Productos:new.html.twig")
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


        $entity = new Productos();
        $form = $this->createForm(new ProductosType($data), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $entity->setUsuarios_productos($this->getUser());

            $entity->setFechaCreacion(new \DateTime('now'));
            $entity->setFechaModificacion(new \DateTime('now'));
            $entity->setActivo(true);
            $entity->setAgotado(false);



            // Solo si se subió la imagen, si no se deja vacio
            if ($form['imagen']->getData()) {
                $name = str_replace('.', '', microtime(true));
                $ex = $form['imagen']->getData()->getClientOriginalExtension();
                $dir = __DIR__ . '../../../../../web/i/';
                $entity->setImagen("$name.$ex");
                $nombre = "$dir$name.$ex";
                $form['imagen']->getData()->move($dir, strtolower($nombre));
            } else {
                //Imagen por defecto
                $entity->setImagen("00000000000000.jpg");
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productos'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Productos entity.
     *
     * @Route("/new", name="productos_new")
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

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );
        $entity = new Productos();
        $form = $this->createForm(new ProductosType($data), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Productos entity.
     *
     * @Route("/{id}", name="productos_show")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Productos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Productos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Productos entity.
     *
     * @Route("/{id}/edit", name="productos_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Productos')->find($id);


        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Productos entity.');
        }

        $editForm = $this->createForm(new ProductosType($data), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Productos entity.
     *
     * @Route("/{id}", name="productos_update")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("PUT")
     * @Template("QPvBundle:Productos:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {

        $idUser = $this->getUser()->getId();
        $query = new QuerySelect($this->get('database_connection'));

        $almacenes = $query->selectAlmacenesByIdUser($idUser);
        $impuestos = $query->selectImpuestosByIdUser($idUser);

        $data = array(
            'almacenes' => $almacenes,
            'impuestos' => $impuestos,
        );
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Productos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Productos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProductosType($data), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            if ($editForm['imagen']->getData()) {
                $name = str_replace('.', '', microtime(true));
                $ex = $editForm['imagen']->getData()->getClientOriginalExtension();
                $dir = __DIR__ . '../../../../../web/i/';
                $entity->setImagen("$name.$ex");
                $nombre = "$dir$name.$ex";
                $editForm['imagen']->getData()->move($dir, strtolower($nombre));
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productos'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Productos entity.
     *
     * @Route("/{id}", name="productos_delete")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:Productos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Productos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productos'));
    }

    /**
     * Creates a form to delete a Productos entity by id.
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
