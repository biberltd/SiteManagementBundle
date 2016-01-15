<?php
/**
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com) (C) 2015
 * @license     GPLv3
 *
 * @date        27.12.2015
 */
namespace BiberLtd\Bundle\SiteManagementBundle\Listeners;

use BiberLtd\Bundle\CoreBundle\Core as Core;
use BiberLtd\Bundle\SiteManagementBundle\Services as BundleServices;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MaintenanceListener extends Core{
    /**
     * MaintenanceListener constructor.
     *
     * @param \BiberLtd\Bundle\SiteManagementBundle\Services\SiteManagementModel $siteManagement
     * @param                                                                    $kernel
     */
    public function __construct(BundleServices\SiteManagementModel $siteManagement, $kernel){
        parent::__construct($kernel);
        $this->siteManagement = $siteManagement;
        $this->kernel = $kernel;
    }

    /**
     *
     */
    public function __destruct(){
        foreach($this as $property => $value) {
            $this->$property = null;
        }
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $e
     */
    public function onKernelRequest(GetResponseEvent $e){
        $request = $e->getRequest();

        $currentDomain = $request->getHttpHost();

        $this->session = $this->kernel->getContainer()->get('session');
        if(!$this->session->get('is_logged_in')){
            $response = $this->siteManagement->getSiteByDomain(str_replace('www.', '', $currentDomain));
            $routeName = $request->get('_route');
            if(!$response->error->exist){
                $settings = json_decode($response->result->set->getSettings());
                if(is_object($settings) && isset($settings->maintenance) && $settings->maintenance == true){
                    $url = $this->kernel->getContainer()->get('router')->generate($this->kernel->getContainer()->getParameter('maintenance_route'), [], UrlGeneratorInterface::ABSOLUTE_PATH);
                    if($this->kernel->getContainer()->getParameter('maintenance_route') != $routeName){
                        $e->setResponse(new RedirectResponse($url));
                    }
                }
            }
            if($this->kernel->getContainer()->getParameter('maintenance') !== null && $this->kernel->getContainer()->getParameter('maintenance') === true){
                $url = $this->kernel->getContainer()->get('router')->generate($this->kernel->getContainer()->getParameter('maintenance_route'), [], UrlGeneratorInterface::ABSOLUTE_PATH);
                if($this->kernel->getContainer()->getParameter('maintenance_route') != $routeName){
                    $e->setResponse(new RedirectResponse($url));
                }
            }
        }
    }
}