<?php namespace Tests\Functional;

use Tests\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * Ensure we get back a valid response for the homepage.
     */
    public function testIndex()
    {
        $response = self::$client->request('GET', self::$baseUrl);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('home', $response->getBody());
    }
}
