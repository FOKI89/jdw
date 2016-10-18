<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends WebTestCase
{

    private function _authenticate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'test',
            '_password' => 'test'
        ));
        $client->submit($form);
        return $client;

    }

    public function testCreateRedirectWhenNotAuthenticated()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contacts/add');

        $this->assertTrue(
            $client->getResponse()->isRedirect('http://localhost/login')
        );
    }

    public function testCreateWhenAuthenticated()
    {
        $client = $this->_authenticate();
        $crawler = $client->request('GET', '/contacts/add');
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}
