<?php namespace Tests\Unit\Image\Driver;

use App\Image\Colour;
use PHPUnit_Framework_TestCase;
use App\Image\Driver\ImagickDriver;

class ImagickDriverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that we get back an image resource with the correct dimensions.
     */
    public function testCanvasDimensions()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getHex')
               ->will($this->returnValue('#ffffff'));

        $driver = new ImagickDriver();
        $image = $driver->canvas(200, 200, $colour);
        $object = $image->getCore();

        $this->assertEquals(200, $object->getImageWidth());
        $this->assertEquals(200, $object->getImageHeight());
    }

    /**
     * Tests that we get back an image resource containing
     * the correct background colour.
     */
    public function testCanvasColour()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getHex')
               ->will($this->returnValue('#ffffff'));

        $driver = new ImagickDriver();
        $image = $driver->canvas(200, 200, $colour);

        $this->assertEquals(
            $image->getCore()->getImagePixelColor(0, 0)->getColor(),
            ['r' => 255, 'g' => 255, 'b' => 255, 'a' => 1]
        );
    }

    /**
     * Not sure how to meaningfully test this besides using tesseract
     */
    public function testWriteText()
    {
        return null;
    }

    /**
     * Tests that we get some binary data back.
     */
    public function testEncodePng()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getHex')
               ->will($this->returnValue('#ffffff'));

        $driver = new ImagickDriver();
        $image = $driver->canvas(1, 1, $colour);
        $driver->encodePng($image);
        $resource = imagecreatefromstring($image->getData());

        $this->assertTrue(is_resource($resource));
    }

    /**
     * Tests that we get some binary data back.
     */
    public function testEncodeGif()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getHex')
               ->will($this->returnValue('#ffffff'));

        $driver = new ImagickDriver();
        $image = $driver->canvas(1, 1, $colour);
        $driver->encodeGif($image);
        $resource = imagecreatefromstring($image->getData());

        $this->assertTrue(is_resource($resource));
    }
}
