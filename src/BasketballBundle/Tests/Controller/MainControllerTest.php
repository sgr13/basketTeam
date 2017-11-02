<?php

namespace BasketballBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testMainpage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mainPage');
    }

}
