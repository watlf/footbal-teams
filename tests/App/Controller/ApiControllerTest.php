<?php

namespace App\Controller;

class ApiControllerTest extends AbstractControllerWebTest
{
    public function setUp()
    {
        $this->client = $this->createAuthenticatedClient();
    }

    public function testGetTeamsByLeagueId()
    {
        $this->client->request('GET', 'api/league/1/teams');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $data = json_decode($this->client->getResponse()->getContent());

        $this->assertNotEmpty($data);
    }

    public function testCreateTeam()
    {
        $content = [
            'name' => 'Team Name',
            'strip' => 'test',
        ];
        $this->makeRequest('POST', 'api/league/1/add-team', $content);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateTeamFailure()
    {
        $content = [
            'name' => 'Team Name',
            'strip' => 'test',
        ];
        $this->makeRequest('POST', 'api/league/1/add-team', $content);

        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
        $this->assertContains('is already in use', $this->client->getResponse()->getContent());
    }

    public function testModifyTeam()
    {
        $content = [
            'name' => 'New Name',
            'strip' => 'test',
        ];

        $this->makeRequest('PUT', 'api/edit-team/1', $content);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testModifyTeamFailure()
    {
        $content = [
            'name' => '',
            'strip' => 'test',
        ];

        $this->makeRequest('PUT', 'api/edit-team/1', $content);

        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Expected argument of type', $this->client->getResponse()->getContent());
    }

    public function testDeleteLeague()
    {
        $this->makeRequest('DELETE', 'api/league/1/delete');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
