<?php
/**
 * @vendor      BiberLtd
 * @package		SiteManagementBundle
 * @subpackage	Services
 * @name	    DomainListener
 *
 * @author		Can Berkol
 *
 * @version     1.0.0
 * @date        27.05.2015
 *
 */

namespace BiberLtd\Bundle\MultiLanguageSupport\Listeners;

use BiberLtd\Bundle\CoreBundle\Core as Core;
use BiberLtd\Bundle\MultiLanguageSupportBundle\Services as MLSServices;
use BiberLtd\Bundle\SiteManagementBundle\Services as BundleServices;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DomainListener extends Core{
    private     $container;
    private     $languages;
	private		$ignoreList;
    /**
     * @name            __construct()
     *                  Constructor.
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
     *                  Destructor.
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
     *  				Called onKernelRequest event and handles browser language detection.
     *
     * @author          Can Berkol
     *
     * @since			1.0.0
     * @version         1.0.0
     *
     * @param 			GetResponseEvent 	        $e
     *
     */
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $e){
        $request = $e->getRequest();

		$currentDomain = $request->getHttpHost();

		$response = $this->siteManagement->getSiteByDomain($currentDomain);

		if($response['error']){
			$this->kernel->getContainer()->get('session')->set('_currentSiteId', '');
		}

		$site = $response['result']['set'];

		$this->kernel->getContainer()->get('session')->set('_currentSiteId', $site->getId());
    }
}
/**
 * Change Log
 * ****************************************
 * v1.0.0						26.04.2015
 * TW #
 * Can Berkol
 * ****************************************
 * A __construct()
 * A onKernelRequest()
 */