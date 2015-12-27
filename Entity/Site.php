<?php
/**
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com) (C) 2015
 * @license     GPLv3
 *
 * @date        27.12.2015
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
class Site extends CoreEntity{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=10)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155, nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     * @var string
     */
    private $url_key;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", length=5, nullable=true)
     * @var int
     */
    private $default_language;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $settings;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    public $date_added;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    public $date_updated;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var \DateTime
	 */
	public $date_removed;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @var string
	 */
	private $domain;

	/**
	 * @ORM\OneToMany(targetEntity="BiberLtd\Bundle\SiteManagementBundle\Entity\DomainAliases", mappedBy="site")
	 * @var array
	 */
	private $domains;

	/**
	 * @return mixed
	 */
    public function getId(){
        return $this->id;
    }

	/**
	 * @param string $description
	 *
	 * @return $this
	 */
    public function setDescription(\string $description) {
        if(!$this->setModified('description', $description)->isModified()) {
            return $this;
        }
		$this->description = $description;
		return $this;
    }

	/**
	 * @return string
	 */
    public function getDescription() {
        return $this->description;
    }

	/**
	 * @param int $language
	 *
	 * @return $this
	 */
    public function setDefaultLanguage(\integer $language) {
        if(!$this->setModified('default_language', $language)->isModified()) {
            return $this;
        }
		$this->default_language = $language;
		return $this;
    }

	/**
	 * @return int
	 */
    public function getDefaultLanguage() {
        return $this->default_language;
    }

	/**
	 * @param string $settings
	 *
	 * @return $this
	 */
    public function setSettings(\string $settings) {
        if(!$this->setModified('settings', $settings)->isModified()) {
            return $this;
        }
		$this->settings = $settings;
		return $this;
    }

	/**
	 * @return string
	 */
    public function getSettings() {
        return $this->settings;
    }

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
    public function setTitle(\string $title) {
        if(!$this->setModified('title', $title)->isModified()) {
            return $this;
        }
		$this->title = $title;
		return $this;
    }

	/**
	 * @return string
	 */
    public function getTitle() {
        return $this->title;
    }

	/**
	 * @param string $url_key
	 *
	 * @return $this
	 */
    public function setUrlKey(\string $url_key) {
        if(!$this->setModified('url_key', $url_key)->isModified()) {
            return $this;
        }
		$this->url_key = $url_key;
		return $this;
    }

	/**
	 * @return string
	 */
    public function getUrlKey() {
        return $this->url_key;
    }

	/**
	 * @return string
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @param string $domain
	 *
	 * @return $this
	 */
	public function setDomain(\string $domain) {
		if (!$this->setModified('domain', $domain)->isModified()) {
			return $this;
		}
		$this->domain = $domain;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getDomains() {
		return $this->domains;
	}

	/**
	 * @param array $domains
	 *
	 * @return $this
	 */
	public function setDomains(array $domains) {
		if (!$this->setModified('domains', $domains)->isModified()) {
			return $this;
		}
		$this->domains = $domains;

		return $this;
	}

}