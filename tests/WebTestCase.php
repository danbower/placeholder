<?php namespace Tests;

use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;

class WebTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Client HTTP Client
     */
    protected static $client;

    /**
     * @var string Base URL of application
     */
    protected static $baseUrl;

    public static function setUpBeforeClass()
    {
        self::$baseUrl = 'http://localhost';
        self::$client = new Client();
    }
}
