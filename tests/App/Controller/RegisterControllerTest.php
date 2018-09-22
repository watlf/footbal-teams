<?php

namespace App\Controller;

class RegisterControllerTest extends AbstractControllerWebTest
{
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
        $content = json_encode([
            'username' => 'tom',
            'password' => '12345678',
        ]);

        $this->client->request(
            'POST',
            '/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
