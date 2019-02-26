<?php

namespace ChallengeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminChallengeControllerTest extends WebTestCase
{
    public function testReadadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readAdmin');
    }

    public function testCreateadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createAdmin');
    }

    public function testUpdateadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateAdmin');
    }

    public function testDeleteadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteAdmin');
    }

}
