<?php namespace Tests\Image\Driver;

use App\Image\Image;
use App\Image\Colour;
use App\Image\Driver\GdDriver;
use PHPUnit_Framework_TestCase;

class GdDriverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that we get back an image resource with the correct dimensions.
     */
    public function testCanvasDimensions()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getRgb')
               ->will($this->returnValue([255, 255, 255]));

        $driver = new GdDriver();
        $image = $driver->canvas(200, 200, $colour);
        $resource = $image->getCore();

        $this->assertEquals(200, imagesx($resource));
        $this->assertEquals(200, imagesy($resource));
    }

    /**
     * Tests that we get back an image resource containing
     * the correct background colour.
     */
    public function testCanvasColour()
    {
        $colour = $this->createMock(Colour::class);
        $colour->expects($this->once())
               ->method('getRgb')
               ->will($this->returnValue([155, 155, 155]));

        $driver = new GdDriver();
        $image = $driver->canvas(200, 200, $colour);

        $this->assertEquals(
            ['red' => 155, 'green' => 155, 'blue' => 155, 'alpha' => 0],
            imagecolorsforindex(
                $image->getCore(),
                imagecolorat($image->getCore(), 0, 0)
            )
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
               ->method('getRgb')
               ->will($this->returnValue([255, 255, 255]));

        $driver = new GdDriver();
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
               ->method('getRgb')
               ->will($this->returnValue([255, 255, 255]));

        $driver = new GdDriver();
        $image = $driver->canvas(1, 1, $colour);
        $driver->encodeGif($image);
        $resource = imagecreatefromstring($image->getData());

        $this->assertTrue(is_resource($resource));
    }
}
