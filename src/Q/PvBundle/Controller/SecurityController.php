<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\SecurityContext;
//use Symfony\Component\HttpFoundation\Session\Session;

//use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * @Route("/security")
 */
class SecurityController extends Controller
{

        /**
     * @Route("/login" , name="login")
     * @Route("/login_check", name="login_check")
     * @Template()
     */
    public function loginAction()
    {
        
        $request = $this->getRequest();
        $session = $request->getSession();
        
        // si el usuario ya está logueado lo redirigimos
        // al panel.
        if( $this->getUser() ){
            return $this->redirect($this->generateUrl('panel_index'));
        }
        
        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        
        return $this->render('QPvBundle:Security:login.html.twig', array(
            // el último nombre de usuario ingresado por el usuario
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * @Route("/")
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logoutAction()
    {
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('index_page'));
    }

}
