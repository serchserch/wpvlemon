<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\Tienda;
use Q\PvBundle\Form\TiendaType;


use Q\PvBundle\Resources\Lib\QuerySelect;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Tienda controller.
 *
 * @Route("/panel/tiendas")
 */
class TiendaController extends Controller
{
    /**
     * Lists all Tienda entities.
     *
     * @Route("/", name="tiendas_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = new QuerySelect($this->get('database_connection'));      
        $entities = $query->selectTiendasByIdUser($this->getUser()->getId());
        
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Tienda entity.
     *
     * @Route("/", name="tienda_create")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("POST")
     * @Template("QPvBundle:Tienda:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Tienda();
        $form = $this->createForm(new TiendaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setUsuarios_tienda($this->getUser());
            $entity->setFechaCreacion(new \DateTime);
            $entity->setFechaModificacion(new \DateTime);
            $entity->setActiva(true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tiendas_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Tienda entity.
     *
     * @Route("/new", name="tienda_new")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tienda();
        $form   = $this->createForm(new TiendaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tienda entity.
     *
     * @Route("/{id}", name="tienda_show")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Tienda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tienda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tienda entity.
     *
     * @Route("/{id}/edit", name="tienda_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Tienda')->find($id);

        if (!$entity) {
            return $this->redirect($this->generateUrl('index_page'));
            //throw $this->createNotFoundException('Unable to find Tienda entity.');
        }

        $editForm = $this->createForm(new TiendaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tienda entity.
     *
     * @Route("/{id}", name="tienda_update")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("PUT")
     * @Template("QPvBundle:Tienda:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Tienda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tienda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TiendaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->setFechaModificacion(new \DateTime);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tienda_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tienda entity.
     *
     * @Route("/{id}", name="tienda_delete")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:Tienda')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tienda entity.');
            }
            $entity->setActiva(false);
            //$em->remove($entity);
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tiendas_index'));
    }

    /**
     * Creates a form to delete a Tienda entity by id.
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
