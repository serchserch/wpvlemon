<?php

namespace Q\PvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/info")
 */
class InfoController extends Controller
{
    /**
     * @Route("/contact", name="contact_page")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Route("/terms", name="terms_page")
     * @Template()
     */
    public function termsAction()
    {
        return array();
    }

    /**
     * @Route("/privacy", name="privacy_page")
     * @Template()
     */
    public function privacyAction()
    {
        return array();
    }

    /**
     * @Route("/disclaimer", name="disclaimer_page")
     * @Template()
     */
    public function disclaimerAction()
    {
        return array();
    }

    /**
     * @Route("/help", name="help_page")
     * @Template()
     */
    public function helpAction()
    {
        return array();
    }

    /**
     * @Route("/sitemap", name="sitemap_page")
     * @Template()
     */
    public function sitemapAction()
    {
        return array();
    }
    
    /**
     * @Route("/services", name="services_page")
     * @Template()
     */
    public function servicesAction()
    {
        return array();
    }
    
    /**
     * @Route("/pricing", name="pricing_page")
     * @Template()
     */
    public function pricingAction()
    {
        return array();
    }

}
