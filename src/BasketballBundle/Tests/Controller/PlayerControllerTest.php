<?php

namespace BasketballBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testAddplayer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addPlayer');
    }

    public function testEditplayer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPlayer');
    }

    public function testDeleteplayer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletePlayer');
    }

    public function testCheckin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/checkIn');
    }

    public function testCheckout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/checkOut');
    }

}
