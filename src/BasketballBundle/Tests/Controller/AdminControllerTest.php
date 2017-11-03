<?php

namespace BasketballBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testSelectday()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/SelectDay');
    }

}
