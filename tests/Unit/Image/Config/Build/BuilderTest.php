<?php namespace Tests\Unit\Image\Config\Build;

use App\Image\TrueTypeFont;
use PHPUnit_Framework_TestCase;
use App\Image\Config\Build\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class BuilderTest extends PHPUnit_Framework_TestCase
{
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

        $builder = $this->getMockForAbstractClass(Builder::class, [$request]);
        $builder->setText();
        $config = $builder->getResult();

        $this->assertEquals('foo bar', $config->getText());
    }

    /**
     * Tests that the builder sets a default.
     */
    public function testTextDefault()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);
        $request->query->expects($this->once())
                       ->method('has')
                       ->with('text')
                       ->will($this->returnValue(false));


        $builder = $this->getMockForAbstractClass(Builder::class, [$request]);
        $builder->setWidth();
        $builder->setHeight();
        $builder->setText();

        $config = $builder->getResult();

        $this->assertNotNull($config->getText());
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


        $builder = $this->getMockForAbstractClass(Builder::class, [$request]);
        $builder->setFormat();
        $config = $builder->getResult();

        $this->assertEquals('foo', $config->getFormat());
    }

    /**
     * Tests that the builder sets a default.
     */
    public function testFontDefault()
    {
        $request = $this->createMock(Request::class);

        $request->query = $this->createMock(ParameterBag::class);

        $builder = $this->getMockForAbstractClass(Builder::class, [$request]);
        $builder->setFont();
        $config = $builder->getResult();

        $this->assertInstanceOf(TrueTypeFont::class, $config->getFont());
    }
}
