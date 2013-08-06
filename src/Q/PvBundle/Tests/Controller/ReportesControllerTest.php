<?php

namespace Q\PvBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportesControllerTest extends WebTestCase
{
    public function testDiario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/diario');
    }

    public function testSemanal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/semanal');
    }

    public function testMensual()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mensual');
    }

    public function testAnual()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/anual');
    }

    public function testFechas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fechas');
    }

    public function testMasvendido()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'mas-vendido');
    }

    public function testMenosvendido()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'menos-vendido');
    }

}
