<?php namespace Tests\Integration;

use Exception;
use Tests\ContainerAwareTestCase;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Tests that the "http_kernel" service has been correctly configured.
 */
class HttpKernelTest extends ContainerAwareTestCase
{
    /**
     * Check that the appropriate status code
     * is returned when the matcher cannot find a route.
     */
    public function testHandleNotFound()
    {
        $matcher = $this->createMock(UrlMatcherInterface::class);
        $matcher->method('match')
                ->will($this->throwException(
                    new ResourceNotFoundException()
                ));

        $matcher->method('getContext')
                ->will($this->returnValue(
                    $this->createMock(RequestContext::class)
                ));

        $this->container->set('matcher', $matcher);

        $kernel = $this->container->get('http_kernel');
        $response = $kernel->handle(new Request());

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Check that the appropriate status code
     * is returned when the matcher can find a route.
     */
    public function testHandleOk()
    {
        $matcher = $this->createMock(UrlMatcherInterface::class);
        $matcher->method('match')
                ->will($this->returnValue([
                    '_route' => 'test',
                    '_controller' => function () {
                        return new Response('hit test route');
                    }
                ]));

        $matcher->method('getContext')
                ->will($this->returnValue(
                    $this->createMock(RequestContext::class)
                ));

        $this->container->set('matcher', $matcher);

        $kernel = $this->container->get('http_kernel');
        $response = $kernel->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('hit test route', $response->getContent());
    }

    /**
     * Check that a generic Exception generated during
     * the request life-cycle isn't blackholed by the HTTP kernel.
     *
     * If the concept of environments (e.g. dev, live) are ever
     * introduced then this will be handled better. However for the time
     * being we'll assume the live environment has sensibly configured error reporting.
     */
    public function testHandleException()
    {
        $matcher = $this->createMock(UrlMatcherInterface::class);
        $matcher->method('match')
                ->will($this->returnValue([
                    '_route' => 'exception',
                    '_controller' => function () {
                        throw new Exception();
                    }
                ]));

        $matcher->method('getContext')
                ->will($this->returnValue(
                    $this->createMock(RequestContext::class)
                ));

        $this->container->set('matcher', $matcher);

        $kernel = $this->container->get('http_kernel');

        $this->expectException(Exception::class);

        $kernel->handle(new Request());
    }
}
