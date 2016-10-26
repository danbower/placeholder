<?php namespace Tests\Functional\Image;

use Tests\WebTestCase;
use GuzzleHttp\Exception\ClientException;

class SquareControllerTest extends WebTestCase
{
    /**
     * Tests that standard access produces a valid response.
     */
    public function testStandardRoute()
    {
        $response = self::$client->request(
            'GET',
            sprintf('%s/100', self::$baseUrl)
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('image/png', $response->getHeader('Content-Type')[0]);
    }

    /**
     * Tests that an override of the default with a supported
     * extension produces a valid response.
     */
    public function testWithSupportedFormat()
    {
        $response = self::$client->request(
            'GET',
            sprintf('%s/100.gif', self::$baseUrl)
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('image/gif', $response->getHeader('Content-Type')[0]);
    }

    /**
     * Tests that an override of the default with an unsupported
     * extension produces a client error response.
     */
    public function testWithUnsupportedFormat()
    {
        try {
            self::$client->request(
                'GET',
                sprintf('%s/100.foo', self::$baseUrl)
            );

            $this->assertTrue(false);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * Tests that an override of the default with an invalid
     * colour produces a client error response.
     */
    public function testWithInvalidColour()
    {
        try {
            self::$client->request(
                'GET',
                sprintf('%s/100?bg=foo', self::$baseUrl)
            );

            $this->assertTrue(false);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * Tests that an attempt to render an image with an invalid
     * length produces a client error response.
     */
    public function testWithInvalidLength()
    {
        try {
            self::$client->request(
                'GET',
                sprintf('%s/9999999', self::$baseUrl)
            );

            $this->assertTrue(false);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }
}
