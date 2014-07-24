<?php

namespace BiberLtd\Cores\Bundles\SiteManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/test/site_management_bundle');

        $this->assertTrue($crawler->filter('html:contains("Testing Site Management Bundle.")')->count() > 0);
    }
}
