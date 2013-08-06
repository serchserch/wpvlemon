<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\Impuesto;
use Q\PvBundle\Form\ImpuestoType;

use Q\PvBundle\Resources\Lib\QuerySelect;


use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Impuesto controller.
 *
 * @Route("panel/impuestos")
 */
class ImpuestoController extends Controller
{
    /**
     * Lists all Impuesto entities.
     *
     * @Route("/", name="impuestos_index")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        $query = new QuerySelect($this->get('database_connection'));
        $entities = $query->selectImpuestosByIdUser($this->getUser()->getId());
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Impuesto entity.
     *
     * @Route("/", name="impuesto_create")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("POST")
     * @Template("QPvBundle:Impuesto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Impuesto();
        $form = $this->createForm(new ImpuestoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUsuarios_impuesto($this->getUser());
            $entity->setFechaCreacion(new \DateTime('now'));
            $entity->setFechaModificacion(new \DateTime('now'));
            $entity->setActivo(true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('impuestos_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Impuesto entity.
     *
     * @Route("/new", name="impuesto_new")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Impuesto();
        $form   = $this->createForm(new ImpuestoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Impuesto entity.
     *
     * @Route("/{id}", name="impuesto_show")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Impuesto entity.
     *
     * @Route("/{id}/edit", name="impuesto_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $editForm = $this->createForm(new ImpuestoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Impuesto entity.
     *
     * @Route("/{id}", name="impuesto_update")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("PUT")
     * @Template("QPvBundle:Impuesto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ImpuestoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('impuesto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Impuesto entity.
     *
     * @Route("/{id}", name="impuesto_delete")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:Impuesto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Impuesto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('impuesto_index'));
    }

    /**
     * Creates a form to delete a Impuesto entity by id.
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
