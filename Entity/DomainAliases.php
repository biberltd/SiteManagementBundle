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
 * @ORM\Table(name="domain_aliases", options={"charset":"utf8","collate":"utf8_turkish_ci","engine":"innodb"})
 */
class DomainAliases extends CoreEntity
{
    /**
	 * @ORM\Id
     * @ORM\Column(type="text")
     * @var string
     */
    private $domain;

    /**
	 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="BiberLtd\Bundle\SiteManagementBundle\Entity\Site", inversedBy="domains")
     * @ORM\JoinColumn(name="site", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @var \BiberLtd\Bundle\SiteManagementBundle\Entity\Site
     */
    private $site;

	/**
	 * @return mixed
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @param string $domain
	 *
	 * @return $this
	 */
	public function setDomain(string $domain) {
		if (!$this->setModified('domain', $domain)->isModified()) {
			return $this;
		}
		$this->domain = $domain;

		return $this;
	}

	/**
	 * @return \BiberLtd\Bundle\SiteManagementBundle\Entity\Site
	 */
	public function getSite() {
		return $this->site;
	}

	/**
	 * @param \BiberLtd\Bundle\SiteManagementBundle\Entity\Site $site
	 *
	 * @return $this
	 */
	public function setSite(\BiberLtd\Bundle\SiteManagementBundle\Entity\Site $site) {
		if (!$this->setModified('site', $site)->isModified()) {
			return $this;
		}
		$this->site = $site;

		return $this;
	}
}