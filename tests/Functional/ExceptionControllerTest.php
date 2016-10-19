<?php namespace Tests\Functional;

use Tests\WebTestCase;
use GuzzleHttp\Exception\ClientException;

class ExceptionControllerTest extends WebTestCase
{
    /**
     * Check that we get back a 404 response.
     */
    public function testHandleNotFound()
    {
        try {
            self::$client->request(
                'GET',
                sprintf('%s/no/such/route', self::$baseUrl)
            );

            $this->assertTrue(false);
        } catch (ClientException $e) {
            $this->assertEquals(404, $e->getResponse()->getStatusCode());
        }
    }
}
