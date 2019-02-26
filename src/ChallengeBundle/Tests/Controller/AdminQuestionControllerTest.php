<?php

namespace ChallengeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminQuestionControllerTest extends WebTestCase
{
    public function testCreatequestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createQuestion');
    }

    public function testReadquestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readQuestion');
    }

    public function testUpdatequestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateQuestion');
    }

    public function testDeletequestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteQuestion');
    }

}
