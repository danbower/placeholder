<?php namespace Tests\Unit\Controller;

use ReflectionClass;
use App\Controller\Controller;
use PHPUnit_Framework_TestCase;
use App\Controller\ControllerResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Check that any resolved controller implementing the
     * \Symfony\Component\DependencyInjection\ContainerAwareInterface
     * interface is injected with a ContainerInterface implementation.
     *
     * The method being tested is protected and examining it via the public getController
     * method hits third-party code. getController requires a controller string pointing to a
     * \Symfony\Component\DependencyInjection\ContainerAwareInterface implementation
     * containing a particular public method name which would make this code a bit brittle
     * hence the use of reflection.
     *
     * @covers App\Controller\ControllerResolver::instantiateController
     */
    public function testInstantiationInjectsContainer()
    {
        $container = $this->createMock(ContainerInterface::class);
        $resolver = new ControllerResolver($container);

        $reflector = new ReflectionClass(ControllerResolver::class);
        $method = $reflector->getMethod('instantiateController');
        $method->setAccessible(true);

        $controller = $method->invokeArgs($resolver, [get_class(
            $this->getMockForAbstractClass(Controller::class)
        )]);

        $this->assertAttributeEquals($container, 'container', $controller);
    }
}
