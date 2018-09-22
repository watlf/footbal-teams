<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Console\Input\StringInput;

abstract class AbstractControllerWebTest extends WebTestCase
{
    /* @var Client */
    protected $client;

    protected $router;

    protected static $application;

    /**
     * Heed to prepare a test database for run tests.
     */
    public static function setUpBeforeClass()
    {
        self::runCommand('doctrine:schema:drop --force');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load -n');
    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s -n', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return Client
     */
    protected function createAuthenticatedClient($username = 'johndou', $password = 'password')
    {
        $jsonContent = json_encode(['username' => $username, 'password' => $password]);

        $client = static::createClient();
        $client->request(
            'POST',
            '/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonContent
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * Make a client request.
     *
     * @param string $method
     * @param string $path
     * @param array $content
     */
    protected function makeRequest(string $method, string $path, array $content = [])
    {
        $this->client->request($method, $path, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($content));
    }
}
