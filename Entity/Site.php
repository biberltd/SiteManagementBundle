<?php
/**
 * @name        Site
 * @package     BiberLtd\Bundle\CoreBundle\SiteManagementBundle\Entity
 *
 * @author      Can Berkol
 *              Murat Ünal
 * @version     1.0.5
 * @date        27.04.2015
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com)
 * @license     GPL v3.0
 *
 * @description Model / Entity class.
 *
 */
namespace BiberLtd\Bundle\SiteManagementBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
use BiberLtd\Bundle\CoreBundle\CoreEntity;
/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="site",
 *     options={"charset":"utf8","collate":"utf8_turkish_ci","engine":"innodb"},
 *     indexes={
 *         @ORM\Index(name="idxNSiteDateAdded", columns={"date_added"}),
 *         @ORM\Index(name="idxNSiteDateUpdated", columns={"date_updated"}),
 *         @ORM\Index(name="idxNSiteDateRemoved", columns={"date_removed"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="idxUSiteId", columns={"id"}),
 *         @ORM\UniqueConstraint(name="idxUSiteUrlKey", columns={"url_key"})
 *     }
 * )
 */
class Site extends CoreEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=10)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    private $url_key;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", length=5, nullable=true)
     */
    private $default_language;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $settings;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $date_added;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $date_updated;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	public $date_removed;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $domain;

    /******************************************************************
     * PUBLIC SET AND GET FUNCTIONS                                   *
     ******************************************************************/

    /**
     * @name            getId()
     *                  Gets $id property.
     * .
     * @author          Murat Ünal
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          string          $this->id
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @name                  setDescription ()
     *                                       Sets the description property.
     *                                       Updates the data only if stored value and value to be set are different.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @use             $this->setModified()
     *
     * @param           mixed $description
     *
     * @return          object                $this
     */
    public function setDescription($description) {
        if(!$this->setModified('description', $description)->isModified()) {
            return $this;
        }
		$this->description = $description;
		return $this;
    }

    /**
     * @name            getDescription ()
     *                                 Returns the value of description property.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          mixed           $this->description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @name                  setLanguage ()
     *                                    Sets the language property.
     *                                    Updates the data only if stored value and value to be set are different.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @use             $this->setModified()
     *
     * @param           mixed $language
     *
     * @return          object                $this
     */
    public function setLanguage($language) {
        if(!$this->setModified('language', $language)->isModified()) {
            return $this;
        }
		$this->default_language = $language;
		return $this;
    }

    /**
     * @name            getLanguage ()
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          mixed           $this->language
     */
    public function getLanguage() {
        return $this->default_language;
    }

    /**
     * @name                  setSettings ()
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @use             $this->setModified()
     *
     * @param           mixed $settings
     *
     * @return          object                $this
     */
    public function setSettings($settings) {
        if(!$this->setModified('settings', $settings)->isModified()) {
            return $this;
        }
		$this->settings = $settings;
		return $this;
    }

    /**
     * @name            getSettings ()
     *                              Returns the value of settings property.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          mixed           $this->settings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @name                  setTitle ()
     *                                 Sets the title property.
     *                                 Updates the data only if stored value and value to be set are different.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @use             $this->setModified()
     *
     * @param           mixed $title
     *
     * @return          object                $this
     */
    public function setTitle($title) {
        if(!$this->setModified('title', $title)->isModified()) {
            return $this;
        }
		$this->title = $title;
		return $this;
    }

    /**
     * @name            getTitle ()
	 *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          mixed           $this->title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @name            setUrlKey ()
	 *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @use             $this->setModified()
     *
     * @param           mixed $url_key
     *
     * @return          object                $this
     */
    public function setUrlKey($url_key) {
        if(!$this->setModified('url_key', $url_key)->isModified()) {
            return $this;
        }
		$this->url_key = $url_key;
		return $this;
    }

    /**
     * @name            getUrlKey ()
     *                  Returns the value of url_key property.
     *
     * @author          Can Berkol
     *
     * @since           1.0.0
     * @version         1.0.0
     *
     * @return          mixed           $this->url_key
     */
    public function getUrlKey() {
        return $this->url_key;
    }
	/**
	 * @name        getDomain ()
	 *
	 * @author      Can Berkol
	 *
	 * @since       1.0.5
	 * @version     1.0.5
	 *
	 * @return      mixed
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @name        setDomain ()
	 *
	 * @author      Can Berkol
	 *
	 * @since       1.0.5
	 * @version     1.0.5
	 *
	 * @param       mixed $domain
	 *
	 * @return      $this
	 */
	public function setDomain($domain) {
		if (!$this->setModified('domain', $domain)->isModified()) {
			return $this;
		}
		$this->domain = $domain;

		return $this;
	}
}
/**
 * Change Log:
 * **************************************
 * v1.0.5                      Can Berkol
 * 27.04.2015
 * **************************************
 * A getDomain()
 * A setDomain()
 *
 * **************************************
 * v1.0.4                      Can Berkol
 * 25.01.2014
 * **************************************
 * Now extends CoreEntity
 *
 * **************************************
 * v1.0.3                      Murat Ünal
 * 11.10.2013
 * **************************************
 * A getBlogPostFields()
 * A setBlogPostFields()
 * A getImageCrop()
 * A setImageCrop()
 * A getProductAttribute()
 * A setProductAttribute()
 * * ************************************
 * v1.0.3                      Murat Ünal
 * 11.10.2013
 * **************************************
 * D getMembers_of_sites()
 * D set_members_of_sites()
 * D getMemberGroups()
 * D setMemberGroups()
 * D getMembers()
 * D set_members()
 * D getCourse()
 * D setCourse()
 * D getFaqs()
 * D setFaqs()
 * D getAddresses()
 * D setAddresses()
 * D getTaxRates()
 * D setTaxRates()
 * D getCoupons()
 * D setCoupons()
 * D getShipmentGateways()
 * D setShipmentGateways()
 * D getPaymentGateways()
 * D setPaymentGateways()
 * D get_payment_transactions()
 * D set_payment_transactions()
 * D getBlogPostComments()
 * D setBlogPostComments()
 * D getAdvertisements()
 * D setAdvertisements()
 * D getBlogPosts()
 * D setBlogPosts()
 * D getBlogPostCategories()
 * D setBlogPostCategories()
 * D getBlog()
 * D setBlog()
 * D getBlogPostTags()
 * D setBlogPostTags()
 * D get_social_networks()
 * D set_social_networks()
 * D getPolls()
 * D setPolls()
 * D get_galleries()
 * D set_galleries()
 * D getNewsletter_categories()
 * D setNewsletter_categories()
 * D getNewsletter()
 * D setNewsletter()
 * D getNewsCategory()
 * D setNewsCategory()
 * D getNews()
 * D setNews()
 * D getAward()
 * D setAward()
 * D getModule()
 * D setModule()
 * D getLayouts()
 * D setLayouts()
 * D getTheme()
 * D setTheme()
 * D getPage()
 * D setPage()
 * D getNavigation()
 * D setNavigation()
 * D get_offices()
 * D set_offices()
 * D getFile()
 * D setFile()
 * D get_file_upload_folder()
 * D set_file_upload_folder()
 * D getProductCategory()
 * D setProductCategory()
 * D getProducts_of_site()
 * D setProducts_of_site()
 * D getProduct()
 * D setProduct()
 * D get_translations()
 * D set_translations()
 * D getLanguages()
 * D setLanguages()
 * D get_log()
 * D set_log()
 * D getAction()
 * D setAction()
 * D getSession()
 * D setSession()
 * **************************************
 * v1.0.2                      Can Berkol
 * 04.08.2013
 * **************************************
 * U getSettings()
 * U setSettings()
 * M None-Core functionalities have been commented out.
 *
 * **************************************
 * v1.0.1                      Murat Ünal
 * 19.07.2013
 * **************************************
 * A getAction()
 * A setAction()
 * A getAdvertisements()
 * A setAdvertisements()
 * A getAward()
 * A setAward()
 * A getBlogPostCategories()
 * A setBlogPostCategories()
 * A getBlogPostComments()
 * A setBlogPostComments()
 * A getBlogPostFields()
 * A setBlogPostFields()
 * A getBlogPostTags()
 * A setBlogPostTags()
 * A getBlogPosts()
 * A setBlogPosts()
 * A getDateAdded()
 * A setDateAdded()
 * A getDateUpdated()
 * A setDateUpdated()
 * A getDescription()
 * A setDescription()
 * A getFile()
 * A setFile()
 * A get_file_upload_folder()
 * A set_file_upload_folder()
 * A get_galleries()
 * A set_galleries()
 * A getId()
 * A setId()
 * A getImageCrop()
 * A setImageCrop()
 * A getLanguage()
 * A setLanguage()
 * A getLanguages()
 * A setLanguages()
 * A getLayouts()
 * A setLayouts()
 * A get_log()
 * A set_log()
 * A getMemberGroups()
 * A setMemberGroups()
 * A getMembers()
 * A set_members()
 * A get_members_of_sites()
 * A set_members_of_sites()
 * A getModule()
 * A setModule()
 * A getNavigation()
 * A setNavigation()
 * A getNews()
 * A setNews()
 * A getNewsCategory()
 * A setNewsCategory()
 * A getNewsletter_categories()
 * A setNewsletter_categories()
 * A getNewsletters()
 * A setNewsletters()
 * A get_offices()
 * A set_offices()
 * A getPage()
 * A setPage()
 * A getPolls()
 * A setPolls()
 * A getProductAttribute()
 * A setProductAttribute()
 * A getProductCategory()
 * A setProductCategory()
 * A getProducts()
 * A setProducts()
 * A getProducts_of_site()
 * A setProducts_of_site()
 * A getSession()
 * A setSession()
 * A getSettings()
 * A setSettings()
 * A get_social_networks()
 * A set_social_networks()
 * A getTheme()
 * A setTheme()
 * A getTitle()
 * A setTitle()
 * A get_translation()
 * A set_translation()
 * A getUrlKey()
 * A setUrlKey()
 */
