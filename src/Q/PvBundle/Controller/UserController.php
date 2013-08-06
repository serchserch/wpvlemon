<?php

namespace Q\PvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Q\PvBundle\Entity\User;
use Q\PvBundle\Form\UserType;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * User controller.
 *
 * @Route("/u")
 */
class UserController extends Controller
{

    /**
     * Asegura el password, al insertarlo a la base de datos
     * 
     * @param Entity $entity
     */
    private function securePassword(&$entity)
    {
        $entity->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 3);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
    
    

    /**
     * Lists all User entities.
     *
     * @Route("/", name="u")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('QPvBundle:User')->findAll();

//        return array(
//            'entities' => $entities,
//        );
        return $this->redirect($this->generateUrl('index_page'));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="u_create")
     * @Method("POST")
     * @Template("QPvBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createForm(new UserType(true), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->securePassword($entity);
            $entity->setFechaCreacion(new \DateTime('now'));
            $entity->setFechaModificacion(new \DateTime('now'));
            $entity->setFechaVencimiento(new \DateTime('now'));
            
            // el rol registrado va a ser siempre un usuario con 
            $rol = $em->getRepository('QPvBundle:Role')->findOneByName('ROLE_ADMIN');
            
            $entity->setUser_role($rol);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('index_page'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="u_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form = $this->createForm(new UserType(true), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="u_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/e/", name="u_edit")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     * @Template()
     */
    public function editAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:User')->find($this->getUser()->getId());

        if (!$entity) {
            //throw $this->createNotFoundException('Unable to find User entity.');
            return $this->redirect($this->generateUrl('index_page'));
        }

        $editForm = $this->createForm(new UserType(), $entity);

        $m = false;
        $m = $this->getRequest()->query->get('m');
        return array(
            'm' => $m,
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
        
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="u_update")
     * @Method("PUT")
     * @Template("QPvBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QPvBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);
        
        $currentpass = $entity->getPassword();

        if ($editForm->isValid()) {
            if ($currentpass != $entity->getPassword()){
                $this->securePassword($entity);
            }
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('u_edit',array('m' => true)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="u_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QPvBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('u'));
    }

    /**
     * Creates a form to delete a User entity by id.
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
