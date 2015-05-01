<?php
/**
 * @vendor      BiberLtd
 * @package		SiteManagementBundle
 * @subpackage	Services
 * @name	    DomainListener
 *
 * @author		Can Berkol
 *
 * @version     1.0.2
 * @date        01.05.2015
 *
 */

namespace BiberLtd\Bundle\SiteManagementBundle\Listeners;

use BiberLtd\Bundle\CoreBundle\Core as Core;
use BiberLtd\Bundle\SiteManagementBundle\Services as BundleServices;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DomainListener extends Core{
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
     * @version         1.3.0
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
     * @version         1.0.5
     *
     * @param 			GetResponseEvent 	        $e
     *
     */
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $e){
        $request = $e->getRequest();

		$currentDomain = $request->getHttpHost();

		$response = $this->siteManagement->getSiteByDomain($currentDomain);

		if($response->error->exists){
			$this->kernel->getContainer()->get('session')->set('_currentSiteId', 1);
			return;
		}

		$site = $response->result->set;

		$this->kernel->getContainer()->get('session')->set('_currentSiteId', $site->getId());
		return;
    }
}
/**
 * Change Log
 * ****************************************
 * v1.0.2						01.05.2015
 * Can Berkol
 * ****************************************
 * CR :: Changes made to be compatible with CoreBundle v3.3
 *
 * ****************************************
 * v1.0.1						30.04.2015
 * Can Berkol
 * ****************************************
 * BF :: Namespace fixed.
 * BF :: onKernelRequest :: The code wasn't returning on error.
 *
 * ****************************************
 * v1.0.0						27.04.2015
 * TW #
 * Can Berkol
 * ****************************************
 * A __construct()
 * A onKernelRequest()
 */