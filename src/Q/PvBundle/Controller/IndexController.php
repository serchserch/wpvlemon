<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


//session 
use Symfony\Component\HttpFoundation\Session\Session;


class IndexController extends Controller
{
    /**
     * @Route("/", name="index_page")
     * @Template()
     */
    public function indexAction()
    {
        //$session = $this->getRequest()->getSession();
        //$session->set('name', 'Drak');
        return array();
    }

}
