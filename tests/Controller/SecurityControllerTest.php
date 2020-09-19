<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, ['username' => 'admin', 'password' => 'admin']);
    }

    public function testLoginAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogoutCheck()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $crawler->filter('#logout')->link();
        //$crawler->selectLink('Se déconnecter')->link();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
