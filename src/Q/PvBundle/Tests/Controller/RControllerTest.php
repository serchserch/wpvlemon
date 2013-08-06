<?php

namespace Q\PvBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RControllerTest extends WebTestCase
{
    public function testU()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/u');
    }

}
