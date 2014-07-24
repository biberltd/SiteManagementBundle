<?php
/**
 * InstallController
 *
 * This controller is used to install default / test values to the system.
 * The controller can only be accessed from allowed IP address.
 *
 * @vendor      BiberLtd
 * @package		SiteanagementBundle
 * @subpackage	Controller
 * @name	    InstallController
 *
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (www.biberltd.com)
 *
 * @version     1.0.0
 * @date        04.08.2013
 *
 */

namespace BiberLtd\Core\Bundles\SiteManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception,
    Symfony\Component\HttpFoundation\Response;

class InstallController extends Controller
{
    /** @var $locale                 Holds the locale */
    protected $locale;
    /** @var $request           Jolds the request object */
    protected $request;
    /** @var $session           Holds session object */
    protected $session;
    /** @var $translator        Holds the translator object */
    protected $translator;

    /**
     * @name 			init()
     *  				Each controller must call this function as its first statement.27
     *                  This function acts as a constructor and initializes default values of this controller.
     *
     * @since			1.0.0
     * @version         1.0.0
     * @author          Can Berkol
     *
     */
    protected  function init(){
        /** Use only in TestController */
        if (isset($_SERVER['HTTP_CLIENT_IP'])
            || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
            || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1', '192.168.1.134', '176.43.5.152', '192.168.1.135','192.168.1.145', '88.235.191.124'))
        ) {
            header('HTTP/1.0 403 Forbidden');
            exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
        }
        /** ****************** */
        $this->request = $this->getRequest();
        $this->session = $this->get('session');
        $this->locale = $this->request->getLocale();
        $this->translator = $this->get('translator');
    }
    /**
     * @name 			siteAction()
     *  				DOMAIN/install/site
     *                  Inserts detault site details into database.
     *
     * @since			1.0.0
     * @version         1.0.0
     * @author          Can Berkol
     *
     */
    public function siteAction()
    {
        /** Initialize */
        $this->init();
        $model = $this->get('core_site_management_bundle.model');
        $date = new \DateTime("now", new \DateTimeZone($this->container->getParameter('app_timezone')));
        $default_site = array(
            'title'         => 'Default Site',
            'url_key'       => 'default_site',
            'description'   => 'This is the default site that is added during installation.',
            'settings'      => '',
            'date_added'    => $date,
            'date_updated'  => $date
        );
        /**
         * Insert data into database.
         */
        $response = $model->insert_site($default_site);
        if($response['error']){
            return new Response('It seems like you have already run the install/site command.');
        }
        $http_response = 'Default site added with the following details:<br>'
                    .'<br><strong>title</strong>: '.$default_site['title']
                    .'<br><strong>url_key</strong>: '.$default_site['url_key']
                    .'<br><strong>description</strong>: '.$default_site['description']
                    .'<br><strong>settings</strong>: '.$default_site['settings']
                    .'<br><strong>date_added</strong>: '.$default_site['date_added']->format('Y-m-d h:i')
                    .'<br><strong>date_updated</strong>: '.$default_site['date_updated']->format('Y-m-d h:i');
        return new Response($http_response);
    }
}
/**
 * Change Log:
 * **************************************
 * v1.0.0                      Can Berkol
 * 01.08.2013
 * **************************************
 * A Site Action
 *
 */