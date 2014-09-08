<?php
/**
 * DefaultController
 *
 * Default controller of SiteManagementBundle
 *
 * @vendor      BiberLtd
 * @package		SiteManagementBundle
 * @subpackage	Controller
 * @name	    DefaultController
 *
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (www.biberltd.com)
 *
 * @version     1.0.0
 * @date        01.08.2013
 *
 */

namespace BiberLtd\Bundle\SiteManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception,
    Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indextAction()
    {
        return new Response('SiteManagementBundle');
    }
}
/**
 * Change Log:
 * **************************************
 * v1.0.0                      Can Berkol
 * 01.08.2013
 * **************************************
 * A
 *
 */