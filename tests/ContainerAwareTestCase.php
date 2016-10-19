<?php namespace Tests;

use PHPUnit_Framework_TestCase;

class ContainerAwareTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Initialise the container property.
     *
     * This is run before each test to ensure
     * that any injected mocks are cleared out.
     */
    public function setUp()
    {
        $this->container = require __DIR__ . '/../config/container.php';
    }
}
