<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\Almacen;
use Q\PvBundle\Form\AlmacenType;

use Q\PvBundle\Resources\Lib\QuerySelect;


use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Almacen controller.
 *
 * @Route("/panel/almacenes")
 */
class AlmacenController extends Controller
{
    /**
     * Lists all Almacen entities.
     *
     * @Route("/", name="almacen_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $query = new QuerySelect($this->get('database_connection'));
        $entities = $query->selectAlmacenesByIdUser($this->getUser()->getId());
        
        

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Almacen entity.
     *
     * @Route("/", name="panel_almacen_create")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("POST")
     * @Template("QPvBundle:Almacen:new.html.twig")
     */
    public function createAction(Request $request)
    {
        
        
        
        $entity  = new Almacen();
        $form = $this->createForm(new AlmacenType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setUsuariosAlmacen($this->getUser());
            $entity->setFechaCreacion(new \DateTime('now'));
            $entity->setFechaModificacion(new \DateTime('now'));
            $entity->setActivo(true);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('almacen_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Almacen entity.
     *
     * @Route("/new", name="panel_almacen_new")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Almacen();
        $form   = $this->createForm(new AlmacenType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Almacen entity.
     *
     * @Route("/{id}", name="panel_almacen_show")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Almacen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacen entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Almacen entity.
     *
     * @Route("/{id}/edit", name="panel_almacen_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Almacen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacen entity.');
        }

        $editForm = $this->createForm(new AlmacenType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Almacen entity.
     *
     * @Route("/{id}", name="panel_almacen_update")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("PUT")
     * @Template("QPvBundle:Almacen:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Almacen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Almacen entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AlmacenType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            $entity->setFechaModificacion(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('panel_almacen_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Almacen entity.
     *
     * @Route("/{id}", name="panel_almacen_delete")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:Almacen')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Almacen entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('panel_almacen'));
    }

    /**
     * Creates a form to delete a Almacen entity by id.
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
