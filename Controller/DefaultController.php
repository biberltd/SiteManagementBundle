<?php

namespace BiberLtd\Bundle\SiteManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BiberLtdSiteManagementBundle:Default:index.html.twig', array('name' => $name));
    }
}
