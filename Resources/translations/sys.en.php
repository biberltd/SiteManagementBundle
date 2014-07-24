<?php
/**
 * sys.en.php
 *
 * This file registers the bundle's system (error and success) messages in English.
 *
 * @vendor      BiberLtd
 * @package		Core\Bundles\SiteManagementBundle
 * @subpackage	Resources
 * @name	    sys.en.php
 *
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (www.biberltd.com)
 *
 * @version     1.0.0
 * @date        03.08.2013
 *
 * =============================================================================================================
 * !!! IMPORTANT !!!
 *
 * Depending your environment run the following code after you have modified this file to clear Symfony Cache.
 * Otherwise your changes will NOT take affect!
 *
 * $ sudo -u apache php app/console cache:clear
 * OR
 * $ php app/console cache:clear
 * =============================================================================================================
 * TODOs:
 * None
 */
/** Nested keys are accepted */
return array(
    /** Error messages */
    'err'       => array(
        /** Site Management Model */
        'smm'   => array(
            'duplicate_site'            => 'A site with the same id or url_key already exists in database.',
            'invalid_parameter'         => 'You have provided wrong parameter.',
            'invalid_site_collection'   => 'You must provide an array that contains one or more Site entities or site id numbers.',
            'invalid_sort_order'        => 'Make sure that sort order is an array that matches the method documentation.',
            'not_found'                 => 'The requested site has not been registered with our database.',
            'unknown'                   => 'An unknown error occured or the SiteManagementModel has NOT been created.',
        ),
    ),
    /** Success messages */
    'scc'       => array(
        /** Site Management Model */
        'smm'   => array(
            'default'                   => 'Database transaction is processed successfuly.',
            'deleted'                   => 'Selected sites have been succesfully deleted.',
            'inserted_multiple'         => 'The data has been successfully added to the database.',
            'inserted_single'           => 'The data has been successfully added to the database.',
            'updated_multiple'          => 'The data has been successfully updated.',
            'updated_single'            => 'The data has been successfully updated.',
        ),
    ),
);
/**
 * Change Log
 * **************************************
 * v1.0.0                      Can Berkol
 * 03.08.2013
 * **************************************
 * A err
 * A err.smm
 * A err.smm.unknown
 * A scc
 * A scc.smm
 * A scc.smm.default
 */