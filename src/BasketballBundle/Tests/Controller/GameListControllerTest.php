<?php

namespace BasketballBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameListControllerTest extends WebTestCase
{
    public function testAddgamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addGameList');
    }

    public function testEditgamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editGameList');
    }

    public function testDeletegamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteGameList');
    }

    public function testLoadgamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/loadGameList');
    }

    public function testCheckingamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/checkInGameList');
    }

    public function testCheckoutgamelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/checkOutGameList');
    }

}
