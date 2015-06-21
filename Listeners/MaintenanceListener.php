<?php
/**
 * @vendor      BiberLtd
 * @package		SiteManagementBundle
 * @subpackage	Services
 * @name	    MaintenanceListener
 *
 * @author		Can Berkol
 *
 * @version     1.0.0
 * @date        22.06.2015
 *
 */

namespace BiberLtd\Bundle\SiteManagementBundle\Listeners;

use BiberLtd\Bundle\CoreBundle\Core as Core;
use BiberLtd\Bundle\SiteManagementBundle\Services as BundleServices;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MaintenanceListener extends Core{
    /**
     * @name            __construct()
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @param           BundleServices\SiteManagementModel      $siteManagement
     * @param           object       $kernel
     */
    public function __construct(BundleServices\SiteManagementModel $siteManagement, $kernel){
        parent::__construct($kernel);
        $this->siteManagement = $siteManagement;
        $this->kernel = $kernel;
    }
    /**
     * @name            __destruct()
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     */
    public function __destruct(){
        foreach($this as $property => $value) {
            $this->$property = null;
        }
    }
    /**
     * @name 			onKernelRequest()
     *
     * @author          Can Berkol
     *
     * @since			1.0.0
     * @version         1.0.0
     *
     * @param 			GetResponseEvent 	        $e
     *
     */
    public function onKernelRequest(GetResponseEvent $e){
        $request = $e->getRequest();

        $currentDomain = $request->getHttpHost();

        $response = $this->siteManagement->getSiteByDomain(str_replace('www.', '', $currentDomain));

        if(!$response->error->exist){
            $settings = json_decode($response->result->set->getSettings());
            if(is_object($settings) && isset($settings->maintenance) && $settings->maintenance == true){
                $url = $this->kernel->getContainer()->get('router')->generate($this->kernel->getContainer()->getParameter('maintenance_route'), array(), UrlGeneratorInterface::ABSOLUTE_PATH);
                $e->setResponse(new RedirectResponse($url));
            }
        }

        if($this->kernel->getContainer()->getParameter('maintenance') !== null && $this->kernel->getContainer()->getParameter('maintenance') == true){
            $url = $this->kernel->getContainer()->get('router')->generate($this->kernel->getContainer()->getParameter('maintenance_route'), array(), UrlGeneratorInterface::ABSOLUTE_PATH);

            $e->setResponse(new RedirectResponse($url));
        }

        if($response->error->exist){
            $this->kernel->getContainer()->get('session')->set('_currentSiteId', 1);
            return;
        }

        $site = $response->result->set;


        $this->kernel->getContainer()->get('session')->set('_currentSiteId', $site->getId());
    }
}
/**
 * Change Log
 * ****************************************
 * v1.0.0						 22.06.2015
 * Can Berkol
 * ****************************************
 * File is created.
 */