<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class RegisterControllerTest extends WebTestCase
{
    /* @var Client */
    protected $client;

    protected static $cookie;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testRegisterFail()
    {
        $content = 'some fail data';

        $this->client->request(
            'POST',
            '/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );

        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
    }

    public function testRegister()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
