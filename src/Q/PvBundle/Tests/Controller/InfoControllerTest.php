<?php

namespace Q\PvBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoControllerTest extends WebTestCase
{
    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');
    }

    public function testTerms()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/terms');
    }

    public function testPrivacy()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/privacy');
    }

    public function testDisclaimer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disclaimer');
    }

    public function testHelp()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/help');
    }

    public function testSitemap()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sitemap');
    }

}
