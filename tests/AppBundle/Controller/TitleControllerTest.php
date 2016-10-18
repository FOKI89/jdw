<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;

class TitleControllerTest extends WebTestCase
{
    public function testAuthenticate()
    {
        self::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $OAuthClient = $em->getRepository('AppBundle:OAuth\Client')->findOneById(1);

        $client = static::createClient();
        $parameters = array(
            'client_id' => $OAuthClient->getId() . '_' . $OAuthClient->getRandomId(),
            'client_secret' => $OAuthClient->getSecret(),
            'grant_type' => 'password',
            'username' => 'test',
            'password' => 'test'
        );
        $client->request('GET', '/oauth/v2/token', $parameters);
        $response = $client->getResponse();
        $jsonData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('access_token', $jsonData);
        return $jsonData['access_token'];
    }

    public function testPostWithoutToken()
    {
        $client = static::createClient();
        $data = array(
            'label' => 'dummy'
        );
        $client->request(
            'POST',
            '/api/titles',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($data)
        );
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @depends testAuthenticate
     */
    public function testPostWithInvalidParameters($accessToken)
    {
        $client = static::createClient();
        $data = array(
            'title' => 'dummy'
        );
        $client->request(
            'POST',
            '/api/titles?access_token=' . $accessToken,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($data)
        );
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @depends testAuthenticate
     */
    public function testPostSuccess($accessToken)
    {
        $data = array(
            'label' => 'myLabel'
        );
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/titles?access_token=' . $accessToken,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($data)
        );
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @depends testAuthenticate
     */
    public function testPostWithExtraContent($accessToken)
    {
        $data = array(
            'label' => 'myLabel',
            'extra' => 'extra'
        );
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/titles?access_token=' . $accessToken,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($data)
        );
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
