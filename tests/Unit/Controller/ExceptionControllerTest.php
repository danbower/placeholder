<?php namespace Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;
use App\Controller\ExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;

class ExceptionControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Ensure that a suitable Response is returned
     * when the HTTP kernel cannot match the route.
     */
    public function testHandleNotFound()
    {
        $flattenException = $this->createMock(FlattenException::class);

        $flattenException->expects($this->once())
                         ->method('getStatusCode')
                         ->will($this->returnValue(404));

        $exceptionController = new ExceptionController();

        $response = $exceptionController->handle($flattenException);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Ensure that the FlattenException is sent back for internal errors.
     */
    public function testHandleException()
    {
        $flattenException = $this->createMock(FlattenException::class);

        $flattenException->expects($this->once())
                         ->method('getStatusCode')
                         ->will($this->returnValue(500));

        $exceptionController = new ExceptionController();

        $response = $exceptionController->handle($flattenException);

        $this->assertEquals($response, $flattenException);
    }
}
