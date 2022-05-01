<?php

namespace Common\SeguridadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), 'Status 302 en portada'
        );

        
        $login = $crawler->filter('html:contains("usuario")')->count();

        $this->assertGreaterThan(0, $login, 'Muestra el login');
    }

}
