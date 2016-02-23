<?php
/**
 * @name        DomainAliases
 * @package     BiberLtd\Bundle\CoreBundle\SiteManagementBundle\Entity
 *
 * @author      Can Berkol
 *
 * @version     1.0.1
 * @date        16.07.2015
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
 * @ORM\Table(name="domain_aliases", options={"charset":"utf8","collate":"utf8_turkish_ci","engine":"innodb"})
 */
class DomainAliases extends CoreEntity
{
    /**
	 * 
     * @ORM\Column(type="text")
     * @ORM\Id
     */
    private $domain;

    /**
	 * 
     * @ORM\ManyToOne(targetEntity="BiberLtd\Bundle\SiteManagementBundle\Entity\Site", inversedBy="domains")
     * @ORM\JoinColumn(name="site", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\Id
     */
    private $site;

	/**
	 * @name        getDomain ()
	 *
	 * @author      Can Berkol
	 *
	 * @since       1.0.0
	 * @version     1.0.0
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
	 * @since       1.0.0
	 * @version     1.0.0
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

	/**
	 * @name        getSite ()
	 *
	 * @author      Can Berkol
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @return      mixed
	 */
	public function getSite() {
		return $this->site;
	}

	/**
	 * @name        setSite ()
	 *
	 * @author      Can Berkol
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @param       mixed $site
	 *
	 * @return      $this
	 */
	public function setSite($site) {
		if (!$this->setModified('site', $site)->isModified()) {
			return $this;
		}
		$this->site = $site;

		return $this;
	}
}
/**
 * Change Log:
 * **************************************
 * v1.0.1                      16.07.2015
 * Can Berkol
 * **************************************
 * BF :: Missing primary key definitions added.
 * BF :: schema definition is removed.
 *
 * **************************************
 * v1.0.0                      14.07.2015
 * Can Berkol
 * **************************************
 * FR :: 3806788 :: File created
 */