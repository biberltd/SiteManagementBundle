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

class DomainListener extends Core{
    /**
     * DomainListener constructor.
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
     * Destructor
     */
    public function __destruct(){
        foreach($this as $property => $value) {
            $this->$property = null;
        }
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $e
     */
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $e){
        $request = $e->getRequest();

        $currentDomain = $request->getHttpHost();
        if (false !== strpos($currentDomain,':')) {
            $currentDomain = explode(':',$currentDomain);
            $currentDomain = $currentDomain[0];
        }
        $response = $this->siteManagement->getSiteByDomain(str_replace('www.', '', $currentDomain));

		if($response->error->exist){
			$this->kernel->getContainer()->get('session')->set('_currentSiteId', 1);
			return;
		}

		$site = $response->result->set;

        $this->kernel->getContainer()->get('session')->set('_currentSiteId', $site->getId());
        return;
    }
}