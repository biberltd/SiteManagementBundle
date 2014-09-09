<?php
/**
 * SiteManagementModel Class
 *
 * This class acts as a database proxy model for SiteManagementBundle functionalities.
 *
 * @vendor      BiberLtd
 * @package		Core\Bundles\SiteManagementBundle
 * @subpackage	Services
 * @name	    SitesManagementModel
 *
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (www.biberltd.com)
 *
 * @version     1.0.5
 * @date        20.02.2014
 *
 * =============================================================================================================
 * !! INSTRUCTIONS ON IMPORTANT ASPECTS OF MODEL METHODS !!!
 *
 * Each model function must return a $response ARRAY.
 * The array must contain the following keys and corresponding values.
 *
 * $response = array(
 *              'result'    =>   An array that contains the following keys:
 *                               'set'         Actual result set returned from ORM or null
 *                               'total_rows'  0 or number of total rows
 *                               'last_insert_id' The id of the item that is added last (if insert action)
 *              'error'     =>   true if there is an error; false if there is none.
 *              'code'      =>   null or a semantic and short English string that defines the error concanated
 *                               with dots, prefixed with err and the initials of the name of model class.
 *                               EXAMPLE: err.amm.action.not.found success messages have a prefix called scc..
 *
 *                               NOTE: DO NOT FORGET TO ADD AN ENTRY FOR ERROR CODE IN BUNDLE'S
 *                               RESOURCES/TRANSLATIONS FOLDER FOR EACH LANGUAGE.
 * =============================================================================================================
 * TODOs:
 * Do not forget to implement ORDER, AND PAGINATION RELATED FUNCTIONALITY
 *
 * @todo v1.0.1     list_all_sites()        uses list_sites()
 * @todo v1.0.1     list_recently_added_sites($period, $sort_order, $limit)         uses list_sites()
 * @todo v1.0.1     list_recently_updated_sites($period, $sort_order, $limit)       uses list_sites()
 * @todo v1.0.1     list_sites_in_given_language($language, $sort_order, $limit)    uses list_sites()
 * @todo v1.0.1     list_sites_added_after($date, $$sort_oder, $limit)    uses list_sites()
 * @todo v1.0.1     list_sites_added_before($date, $sort_oder, $limit)    uses list_sites()
 * @todo v1.0.1     list_sites_added_between($date_start, $date_end, $sort_oder, $limit)    uses list_sites()
 *
 */

namespace BiberLtd\Bundle\SiteManagementBundle\Services;

/** Extends CoreModel */
use BiberLtd\Bundle\CoreBundle\CoreModel;

/** Required for better & instant error handling for the support team */
use BiberLtd\Bundle\CoreBundle\Exceptions as CoreExceptions;
use BiberLtd\Bundle\SiteManagementBundle\Exceptions as BundleExceptions;

/** Entities to be used */
use BiberLtd\Bundle\SiteManagementBundle\Entity as BundleEntity;

class SiteManagementModel extends CoreModel{
    /**
     * @name            __construct()
     *                  Constructor.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.3
     *
     * @param           object          $kernel
     * @param           string          $db_connection  Database connection key as set in app/config.yml
     * @param           string          $orm            ORM that is used.
     */
    public function __construct($kernel, $db_connection = 'default', $orm = 'doctrine'){
        parent::__construct($kernel, $db_connection, $orm);

        /**
         * Register entity names for easy reference.
         */
        $this->entity = array(
            'site'    => array('name' => 'SiteManagementBundle:Site', 'alias' => 's'),
        );
    }
    /**
     * @name            __destruct()
     *                  Destructor.
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
     * @name 			deleteSites()
     *  				Deletes provided sites from database. If the site does not exist, throws
     *                  SiteDoesNotExistException.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->doesSiteExist()
     * @use             $this->createException()
     *
     * @param           array           $sites      Collection of Site entities or site ids.
     *
     * @return          array           $response
     */
    public function deleteSites($sites){
        /** Parameter must be an array */
        if(!is_array($sites)){
            return $this->createException('InvalidParameterException', 'Site entity', 'err.invalid.parameter.collection');
        }
        $site_ids = array();
        /** Loop through sites and collect ids. */
        foreach($sites as $site){
            $id = '';
            if(is_object($site)){
                if(!$site instanceof BundleEntity\Site){
                    return $this->createException('InvalidEntityException', 'Site entity', 'err.invalid.parameter.collection');
                }
                $id = $site->getId();
            }
            else if(is_numeric($site)){
                $id = $site;
            }
            else{
                /** If array values are not numeric nor object */
                return $this->createException('InvalidParameterException', 'Site entity', 'err.invalid.parameter.collection');
            }
            /**
             * Check if site exits in database.
             */
            if($this->doesSiteExist($id, true)){
                $site_ids[] = $id;
            }
            else{
                new CoreExceptions\EntityDoesNotExistException($this->kernel, $id, 'site');
            }
        }
        /**
         * Control if there is any site id in collection.
         */
        if(count($site_ids) < 1){
            return $this->createException('InvalidParameternException', 'Site entity collection', 'err.invalid.parameter.collection');
        }
        /**
         * 2. Prepare query string.
         */
        $query_str = 'DELETE '.$this->entity['site']['alias'].' FROM '.$this->entity['site']['name'].' '.$this->entity['site']['alias']
                        .' WHERE '.$this->entity['site']['alias'].'.id IN (:site_ids)';
        /**
         * 3. Create query object.
         */
        $site_ids = implode(',', $site_ids );

        $query = $this->em->createQuery($query_str);
        $query->setParameter('site_ids', $site_ids);
        /**
         * 5. Free memory.
         */
        unset($sites);
        /**
         * 6. Run query
         */
        $query->getResult();
        /**
         * Prepare & Return Response
         */
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $site_ids,
                'total_rows'    => count($site_ids),
                'last_insert_id'=> null,
            ),
            'error'      => false,
            'code'       => 'scc.db.delete.done',
        );
    }
    /**
     * @name 			deleteSite()
     *  				Deletes an existing site from database. If the site does not exist, throws
     *                  SiteDoesNotExistException.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->deleteSites()
     *
     * @param           mixed           $site           Site entity or site id.
     * @return          mixed           $response
     */
    public function deleteSite($site){
        return $this->deleteSites(array($site));
    }
    /**
     * @name 			listSites()
     *  				List registered sites from database based on a variety of conditions.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->doesSiteExist()
     *
     * @param           array           $filter             Multi-dimensional array
     *
     *                                  Example:
     *                                  $filter = array(
     *                                      'address_type'  => array('in' => array(2,5),
     *                                                               'not_in' => array(4)
     *                                                              ),
     *                                      'member'        => array('in' => array(Member1, Member2)),
     *                                      'tax_id'        => 21312412,
     *                                  );
     *
     *                                  Each array element defines an AND condition.
     *                                  Each array element contains another array with keys
     *                                  in and not_in to include and to exclude data.
     *                                  Each nested array element that is containted in condition states
     *                                  an OR condition.
     *
     * @param           array           $sortorder              Array
     *                                      'column'            => 'asc|desc'
     * @param           array           $limit
     *                                      start
     *                                      count
     *
     * @return          array           $response
     */
    public function listSites($filter = null, $sortorder = null, $limit = null){
        if(!is_array($sortorder) && !is_null($sortorder)){
            return $this->createException('InvalidParameterException', 'sortorder', 'err.invalid.parameter.sortorder');
        }
        $query_str = 'SELECT '.$this->entity['site']['alias'].' FROM '.$this->entity['site']['name'].' '.$this->entity['site']['alias'];
        $order_str = '';
        $where_str = '';
        /**
         * Prepare ORDER BY part of query.
         */
        if($sortorder != null){
            foreach($sortorder as $column => $direction){
                $order_str .= ' s.'.$column.' '.$direction.', ';
            }
            $order_str = rtrim($order_str, ', ');
            $order_str = ' ORDER BY '.$order_str.' ';
        }
        if($filter != null){
            $and = '(';
            foreach($filter as $column => $value){
                /** If value is array we need to run through all values with a loop */
                if(is_array($value)){
                    $or = '(';
                    foreach($value as $key => $sub_value){
                        if(!is_array($sub_value)){
                            new CoreExceptions\InvalidFilterException($this->kernel, '');
                            break;
                        }
                        $tmp_sub_value = array();
                        foreach($sub_value as $item){
                            if(!is_object($item)){
                                $tmp_sub_value[] = $item->getId();
                            }
                        }
                        if(count($tmp_sub_value) > 0){
                            $sub_value = $tmp_sub_value;
                        }

                        $or .= ' '.$this->entity['site']['alias'].'.'.$key;
                        switch($key){
                            case 'in':
                            case 'include':
                                $in = implode(',', $sub_value);
                                $or .= ' IN('.$in.') ';
                                break;
                            case 'not_in':
                            case 'exclude':
                                $not_in = implode(',', $sub_value);
                                $or .= ' NOT IN('.$not_in.') ';
                                break;
                        }
                        $or .= ') OR ';
                    }
                    $or = rtrim($or, ' OR');
                    $and .= $or;
                }
                else{
                    if(is_object($value)){
                        $value = $value->getId();
                    }
                    if(is_numeric($value)){
                        $and .= ' '.$this->entity['site']['alias'].'.'.$column.' = '.$value;
                    }
                    else{
                        $and .= ' '.$this->entity['site']['alias'].'.'.$column.' = \''.$value.'\'';
                    }
                }
                $and .= ' AND ';
            }
            $and = rtrim($and, ' AND').')';
            $where_str .= ' WHERE '.$and;
        }

        $query_str .= $where_str.$order_str;
        $query = $this->em->createQuery($query_str);
        $query = $this->addLimit($query, $limit);
        
        $result = $query->getResult();
        /**
         * Prepare & Return Response
         */
        $total_rows = count($result);
        if($total_rows < 1){
            $this->response['error'] = true;
            $this->response['code'] = 'err.db.entry.notexist';
            return $this->response;
        }
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $result,
                'total_rows'    => $total_rows,
                'last_insert_id'=> null,
            ),
            'error'      => false,
            'code'       => 'scc.db.entry.exist',
        );
        return $this->response;
    }
    /**
     * @name 			getSite()
     *  				Returns details of a site.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->listSites()
     *
     * @param           mixed           $site           Site entity or site id.
     * @param           string          $by             id or url_key
     * @return          mixed           $response
     */
    public function getSite($site, $by = 'id'){
        if($by != 'id' && $by != 'url_key'){
            return $this->createException('InvalidParameterException', 'id, url_key', 'invalid.parameter.by');
        }
        if(!is_object($site) && !is_numeric($site) && !is_string($site)){
            return $this->createException('InvalidParameterException', 'Site entity, id, or url_key', 'invalid.parameter.site');
        }
        if(is_object($site)){
            if(!$site instanceof BundleEntity\Site){
                return $this->createException('InvalidParameterException', 'Site entity, id, or url_key', 'invalid.parameter.site');

            }
            $site = $site->getId();
        }
        $filter = array(
            $by    =>   $site
        );
        $response = $this->listSites($filter, null, array('start' => 0, 'count' => 1));
        if($response['error']){
            return $response;
        }
        $collection = $response['result']['set'];
        /**
         * Prepare & Return Response
         */
        
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $collection[0],
                'total_rows'    => 1,
                'last_insert_id'=> null,
            ),
            'error'      => false,
            'code'       => 'scc.db.entry.exist',
        );
        return $this->response;
    }
    /**
     * @name 			getSiteSettings()
     *  				Returns site settings decoded.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->getSite()
     *
     * @param           mixed           $site           Site entity or site id.
     * @param           bool            $bypass         If set to true does not return response but only the result.
     *
     * @return          mixed           $response
     */
    public function getSiteSettings($site, $bypass = false){
        $response = $this->getSite($site);

        if($response['error']){
            return $response;
        }

        $site = $response['result']['set'];

        $settings = $site->getSettings();

        if($bypass){
            return $settings;
        }
        /**
         * Prepare & Return Response
         */
        $total_rows = count($settings);
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $settings,
                'total_rows'    => $total_rows,
                'last_insert_id'=> null,
            ),
            'error'      => true,
            'code'       => 'scc.entry.exists',
        );
        return $this->response;
    }
    /**
     * @name 			doesSiteExist()
     *  				Checks if site exists in database.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->getSite()
     *
     * @param           mixed           $site           Site entity or site id.
     * @param           string          $by             id or url_key
     * @param           bool            $bypass         If set to true does not return response but only the result.
     *
     * @return          mixed           $response
     */
    public function doesSiteExist($site, $by = 'id', $bypass = false){
        $response = $this->getSite($site, $by);
        if($response['error']){
            return $response;
        }
        $exist = false;
        if($response['result']['total_rows'] > 0){
            $exist = true;
        }

        if($bypass){
            return $exist;
        }
        /**
         * Prepare & Return Response
         */
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $exist,
                'total_rows'    => 1,
                'last_insert_id'=> null,
            ),
            'error'      => false,
            'code'       => 'scc.db.entry.exist',
        );
        return $this->response;
    }
    /**
     * @name 			getDefaultLanguage()
     *  				Returns default language entity.
     *
     * @since			1.0.6
     * @version         1.0.6
     * @author          Said İmamoğlu
     *
     * @use             $this->getSite()
     *
     * @param           mixed           $site           Site entity or site id.
     * @param           string          $by             id or url_key
     * @param           bool            $bypass         If set to true does not return response but only the result.
     *
     * @return          mixed           $response
     */
    public function getDefaultLanguage($site, $by = 'id', $bypass = false){
        $response = $this->getSite($site, $by);
        if($response['error']){
            return $response;
        }
        $exist = false;
        if($response['result']['total_rows'] > 0){
            $exist = true;
        }

        if($bypass){
            return $response['result']['set']->getLanguage();
        }
        /**
         * Prepare & Return Response
         */
        $this->response = array(
	    'rowCount' => $this->response['rowCount'],
            'result'     => array(
                'set'           => $response['result']['set']->getLanguage(),
                'total_rows'    => 1,
                'last_insert_id'=> null,
            ),
            'error'      => false,
            'code'       => 'scc.db.entry.exist',
        );
        return $this->response;
    }
   
    /**
     * @name 			insertSites()
     *  				Inserts one or more sites into database.
     *
     * @since			1.0.0
     * @version         1.0.5
     * @author          Can Berkol
     *
     * @use             $this->doesSiteExist()
     * @use             $this->createException()
     *
     * @param           array           $collection      Collection of Site entities or array of site detais array.
     *
     * @return          array           $response
     */
    public function insertSites($collection){
        $this->resetResponse();
        /** Parameter must be an array */
        if (!is_array($collection)) {
            return $this->createException('InvalidParameterException', 'Array', 'err.invalid.parameter.collection');
        }
        $countInserts = 0;
        $insertedItems = array();
        foreach($collection as $data){
            if($data instanceof BundleEntity\Product){
                $entity = $data;
                $this->em->persist($entity);
                $insertedItems[] = $entity;
                $countInserts++;
            }
            else if(is_object($data)){
                $localizations = array();
                $entity = new BundleEntity\Product;
                if(!property_exists($data, 'date_added')){
                    $data->date_added = new \DateTime('now', new \DateTimeZone($this->kernel->getContainer()->getParameter('app_timezone')));
                }
                if(!property_exists($data, 'date_updated')){
                    $data->date_updated = new \DateTime('now', new \DateTimeZone($this->kernel->getContainer()->getParameter('app_timezone')));
                }
                if(!property_exists($data, 'default_language')){
                    $data->default_language = 1;
                }
                foreach($data as $column => $value){
                    $localeSet = false;
                    $set = 'set'.$this->translateColumnName($column);
                    switch($column){
                        case 'default_language':
                            $lModel = $this->kernel->getContainer()->get('multilanguagesupport.model');
                            $response = $lModel->getLanguage($value, 'id');
                            if(!$response['error']){
                                $entity->$set($response['result']['set']);
                            }
                            else{
                                new CoreExceptions\SiteDoesNotExistException($this->kernel, $value);
                            }
                            unset($response, $sModel);
                            break;
                        default:
                            $entity->$set($value);
                            break;
                    }
                    if($localeSet){
                        $localizations[$countInserts]['entity'] = $entity;
                    }
                }
                $this->em->persist($entity);
                $insertedItems[] = $entity;

                $countInserts++;
            }
            else{
                new CoreExceptions\InvalidDataException($this->kernel);
            }
        }
        if($countInserts > 0){
            $this->em->flush();
        }
        /**
         * Prepare & Return Response
         */
        $this->response = array(
            'rowCount' => $this->response['rowCount'],
            'result' => array(
                'set' => $insertedItems,
                'total_rows' => $countInserts,
                'last_insert_id' => $entity->getId(),
            ),
            'error' => false,
            'code' => 'scc.db.insert.done',
        );
        return $this->response;
    }
    /**
     * @name 			insertSite()
     *  				Inserts one site into database.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->insertSite()
     *
     * @param           mixed           $site      Site Entity or a collection of post input that stores site details.
     *
     * @return          array           $response
     */
    public function insertSite($site){
        return $this->insertSites(array($site));
    }
    /**
     * @name 			updateSites()
     *  				Updates one or more group details in database.
     *
     * @since			1.0.0
     * @version         1.0.5
     * @author          Can Berkol
     *
     * @use             $this->doesSiteExist()
     *
     * @ue              $this->createException()
     *
     * @param           array           $collection      Collection of Page entities or array of entity details.
     *
     * @return          array           $response
     */
    public function updateSites($collection){
        $this->resetResponse();
        /** Parameter must be an array */
        if (!is_array($collection)) {
            return $this->createException('InvalidParameterException', 'Array', 'err.invalid.parameter.collection');
        }
        $countUpdates = 0;
        $updatedItems = array();
        foreach($collection as $data){
            if($data instanceof BundleEntity\Site){
                $entity = $data;
                $this->em->persist($entity);
                $updatedItems[] = $entity;
                $countUpdates++;
            }
            else if(is_object($data)){
                if(!property_exists($data, 'id') || !is_numeric($data->id)){
                    return $this->createException('InvalidParameterException', 'Each data must contain a valid identifier id, integer', 'err.invalid.parameter.collection');
                }
                if(!property_exists($data, 'date_updated')){
                    $data->date_updated = new \DateTime('now', new \DateTimeZone($this->kernel->getContainer()->getParameter('app_timezone')));
                }
                if(!property_exists($data, 'date_added')){
                    unset($data->date_added);
                }
                if(!property_exists($data, 'default_language')){
                    $data->default_language = 1;
                }
                $response = $this->getSite($data->id, 'id');
                if($response['error']){
                    return $this->createException('EntityDoesNotExist', 'Product with id '.$data->id, 'err.invalid.entity');
                }
                $oldEntity = $response['result']['set'];
                foreach($data as $column => $value){
                    $set = 'set'.$this->translateColumnName($column);
                    switch($column){
                        case 'site':
                            $sModel = $this->kernel->getContainer()->get('sitemanagement.model');
                            $response = $sModel->getSite($value, 'id');
                            if(!$response['error']){
                                $oldEntity->$set($response['result']['set']);
                            }
                            else{
                                new CoreExceptions\SiteDoesNotExistException($this->kernel, $value);
                            }
                            unset($response, $sModel);
                            break;
                        case 'default_language':
                            $lModel = $this->kernel->getContainer()->get('multilanguagesupport.model');
                            $response = $lModel->getLanguage($value, 'iso_code');
                            if(!$response['error']){
                                $response = $lModel->getLanguage($value, 'id');
                                if(!$response['error']){
                                    $oldEntity->$set($response['result']['set']);
                                }
                            }
                            else{
                                new CoreExceptions\EntityDoesNotExistException($this->kernel, $value);
                            }
                            unset($response, $sModel);
                            break;
                        case 'id':
                            break;
                        default:
                            $oldEntity->$set($value);
                            break;
                    }
                    if($oldEntity->isModified()){
                        $this->em->persist($oldEntity);
                        $countUpdates++;
                        $updatedItems[] = $oldEntity;
                    }
                }
            }
            else{
                new CoreExceptions\InvalidDataException($this->kernel);
            }
        }
        if($countUpdates > 0){
            $this->em->flush();
        }
        /**
         * Prepare & Return Response
         */
        $this->response = array(
            'rowCount' => $this->response['rowCount'],
            'result' => array(
                'set' => $updatedItems,
                'total_rows' => $countUpdates,
                'last_insert_id' => null,
            ),
            'error' => false,
            'code' => 'scc.db.update.done',
        );
        return $this->response;
    }
    /**
     * @name 			updateSite()
     *  				Update one or more sites into database.
     *
     * @since			1.0.0
     * @version         1.0.3
     * @author          Can Berkol
     *
     * @use             $this->updateSites()
     *
     * @param           array           $site      Site Entity or a collection of post input that stores site details.
     *
     * @return          array           $response
     */
    public function updateSite($site){
        return $this->updateSites(array($site));
    }
}

/**
 * Change Log
 * **************************************
 * v1.0.6                      Said İmamoğlu
 * 21.02.2014
 * **************************************
 * A getDefaultLanguage
 * 
 * **************************************
 * v1.0.5                      Can Berkol
 * 20.02.2014
 * **************************************
 * U insertSites()
 * U updateSites()
 *
 * **************************************
 * v1.0.4                      Can Berkol
 * 25.01.2014
 * **************************************
 * B updateSite()
 * U updateSites()
 *
 * **************************************
 * v1.0.3                      Can Berkol
 * 07.11.2013
 * **************************************
 * M The class now extends CoreModel
 * M Methods now use $this->createException() method.
 * M Method names are now camelCase.
 *
 * **************************************
 * v1.0.2                      Can Berkol
 * 16.08.2013
 * **************************************
 * B list_sites() NULL filter query problem fixed.
 *
 * **************************************
 * v1.0.1                      Can Berkol
 * 05.08.2013
 * **************************************
 * B delete_sites() Query parameter was not being set.
 *
 * **************************************
 * v1.0.0                      Can Berkol
 * 03.08.2013
 * **************************************
 * A __construct()
 * A __destruct()
 * A delete_site()
 * A delete_sites()
 * A does_site_exist()
 * A getSite()
 * A getSite_settings()
 * A insert_site()
 * A insert_sites()
 * A list_sites()
 * A update_site()
 * A update_sites()
 */