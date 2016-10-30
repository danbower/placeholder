<?php namespace Tests\Unit\Image\Config\Build;

use App\Image\Colour;
use PHPUnit_Framework_TestCase;
use App\Image\Config\Validator;
use App\Image\Config\Build\RandomisedBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class RandomBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that the width constraint override is honoured.
     */
    public function testWidthConstraint()
    {
        $request = $this->createMock(Request::class);
        $request->query = $this->createMock(ParameterBag::class);
        $request->query->method('has')
                       ->will($this->returnValue(true));

        $request->query->method('get')
                 ->will($this->onConsecutiveCalls(
                     Validator::MAX_LENGTH - 1,
                     Validator::MAX_LENGTH
                 ));

        $builder = new RandomisedBuilder($request);

        $builder->setWidth();
        $config = $builder->getResult();

        $this->assertTrue(
            $config->getWidth() === Validator::MAX_LENGTH ||
            $config->getWidth() === Validator::MAX_LENGTH - 1
        );
    }

    /**
     * Test that the height constraint override is honoured.
     */
    public function testHeightConstraint()
    {
        $request = $this->createMock(Request::class);
        $request->query = $this->createMock(ParameterBag::class);
        $request->query->method('has')
                       ->will($this->returnValue(true));

        $request->query->method('get')
                 ->will($this->onConsecutiveCalls(
                     Validator::MAX_LENGTH - 1,
                     Validator::MAX_LENGTH
                 ));

        $builder = new RandomisedBuilder($request);

        $builder->setHeight();
        $config = $builder->getResult();

        $this->assertTrue(
            $config->getHeight() === Validator::MAX_LENGTH ||
            $config->getHeight() === Validator::MAX_LENGTH - 1
        );
    }

    /**
     * Tests that the background colour defined within
     * the querystring correctly creates a Colour.
     */
    public function testBackgroundColourTransform()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('bg')
                       ->will($this->returnValue(true));

        $request->query->expects($this->once())
                       ->method('get')
                       ->with('bg')
                       ->will($this->returnValue('#999999'));

        $builder = new RandomisedBuilder($request);
        $builder->setBackgroundColour();
        $config = $builder->getResult();

        $this->assertEquals('#999999', $config->getBackgroundColour()->getHex());
    }

    /**
     * Tests that the builder sets a default
     */
    public function testBackgroundDefault()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('bg')
                       ->will($this->returnValue(false));

        $builder = new RandomisedBuilder($request);
        $builder->setBackgroundColour();
        $config = $builder->getResult();

        $this->assertInstanceOf(Colour::class, $config->getBackgroundColour());
    }

    /**
     * Tests that the foreground colour defined within
     * the querystring correcly creates a Colour.
     */
    public function testForegroundColourTransform()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('fg')
                       ->will($this->returnValue(true));

        $request->query->expects($this->once())
                       ->method('get')
                       ->with('fg')
                       ->will($this->returnValue('#777777'));

        $builder = new RandomisedBuilder($request);
        $builder->setForegroundColour();
        $config = $builder->getResult();

        $this->assertEquals('#777777', $config->getForegroundColour()->getHex());
    }

    /**
     * Tests that the builder sets a default
     */
    public function testForegroundDefault()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('fg')
                       ->will($this->returnValue(false));

        $builder = new RandomisedBuilder($request);
        $builder->setForegroundColour();
        $config = $builder->getResult();

        $this->assertInstanceOf(Colour::class, $config->getForegroundColour());
    }
}
