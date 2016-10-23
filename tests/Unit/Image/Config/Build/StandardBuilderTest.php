<?php namespace Tests\Image\Config\Build;

use PHPUnit_Framework_TestCase;
use App\Image\Config\Build\StandardBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class StandardBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that the width passed-in sets the relevant property.
     */
    public function testWidthTransform()
    {
        $request = $this->createMock(Request::class);

        $builder = new StandardBuilder(101, 200, $request);
        $builder->setWidth();
        $config = $builder->getResult();

        $this->assertEquals(101, $config->getWidth());
    }

    /**
     * Tests that the height passed-in sets the relevant property.
     */
    public function testHeightTransform()
    {
        $request = $this->createMock(Request::class);

        $builder = new StandardBuilder(200, 101, $request);
        $builder->setHeight();
        $config = $builder->getResult();

        $this->assertEquals(101, $config->getHeight());
    }

    /**
     * Tests that the "text" defined within the querystring
     * sets the relevant property.
     */
    public function testTextTransform()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('text')
                       ->will($this->returnValue(true));

        $request->query->expects($this->once())
                       ->method('get')
                       ->with('text')
                       ->will($this->returnValue('foo bar'));


        $builder = new StandardBuilder(200, 200, $request);
        $builder->setText();
        $config = $builder->getResult();

        $this->assertEquals('foo bar', $config->getText());
    }

    /**
     * Tests that the "text" property has a sensible value recalculated.
     */
    public function testTextDefault()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('text')
                       ->will($this->returnValue(false));


        $builder = new StandardBuilder(123, 321, $request);
        $builder->setWidth();
        $builder->setHeight();
        $builder->setText();

        $config = $builder->getResult();

        $this->assertEquals('123x321', $config->getText());
    }

    /**
     * Tests that the "format" defined within the route
     * sets the relevant property.
     */
    public function testFormatTransform()
    {
        $request = $this->createMock(Request::class);

        $request->attributes = $this->createMock(ParameterBag::class);
        $request->attributes->expects($this->once())
                            ->method('get')
                            ->with('format')
                            ->will($this->returnValue('foo'));


        $builder = new StandardBuilder(200, 200, $request);
        $builder->setFormat();
        $config = $builder->getResult();

        $this->assertEquals('foo', $config->getFormat());
    }

    /**
     * Tests that the background colour defined within
     * the querystring sets the relevant property.
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
                       ->will($this->returnValue('999'));

        $builder = new StandardBuilder(200, 200, $request);
        $builder->setBackgroundColour();
        $config = $builder->getResult();

        $this->assertEquals('999', $config->getBackgroundColour());
    }

    /**
     * Tests that the foreground colour defined within
     * the querystring sets the relevant property.
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
                       ->will($this->returnValue('777'));

        $builder = new StandardBuilder(200, 200, $request);
        $builder->setForegroundColour();
        $config = $builder->getResult();

        $this->assertEquals('777', $config->getForegroundColour());
    }
}
