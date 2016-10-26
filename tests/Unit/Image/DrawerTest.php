<?php namespace Tests\Image;

use App\Image\Image;
use App\Image\Drawer;
use App\Image\Colour;
use App\Image\TrueTypeFont;
use App\Image\Config\Config;
use App\Image\Driver\Driver;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class DrawerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Create a Config mock instance.
     */
    protected function createConfigMock()
    {
        $config = $this->createMock(Config::class);
        $config->expects($this->once())
               ->method('getWidth');

        $config->expects($this->once())
               ->method('getHeight');

        $config->expects($this->once())
               ->method('getText');

        $config->expects($this->once())
               ->method('getFont')
               ->will($this->returnValue(
                   $this->createMock(TrueTypeFont::class)
               ));

        $config->expects($this->once())
               ->method('getBackgroundColour')
               ->will($this->returnValue(
                   $this->createMock(Colour::class)
               ));

        $config->expects($this->once())
               ->method('getForegroundColour')
               ->will($this->returnValue(
                   $this->createMock(Colour::class)
               ));

        return $config;
    }

    /**
     * Create a Driver mock instance.
     */
    protected function createDriverMock()
    {
        $driver = $this->createMock(Driver::class);
        $driver->expects($this->once())
               ->method('canvas')
               ->will($this->returnValue(
                   $this->createMock(Image::class)
               ));

        $driver->expects($this->once())
               ->method('writeText');

        return $driver;
    }

    /**
     * Tests that PNG encoding is handled.
     */
    public function testEncodePng()
    {
        $config = $this->createConfigMock();
        $config->expects($this->once())
               ->method('getFormat')
               ->will($this->returnValue('png'));

        $driver = $this->createDriverMock();
        $driver->expects($this->once())
               ->method('encodePng');

        $drawer = new Drawer($driver);
        $image = $drawer->draw($config);

        $this->assertInstanceOf(Image::class, $image);
    }

    /**
     * Tests that GIF encoding is handled.
     */
    public function testEncodeGif()
    {
        $config = $this->createConfigMock();
        $config->expects($this->once())
               ->method('getFormat')
               ->will($this->returnValue('gif'));

        $driver = $this->createDriverMock();
        $driver->expects($this->once())
               ->method('encodeGif');

        $drawer = new Drawer($driver);
        $image = $drawer->draw($config);

        $this->assertInstanceOf(Image::class, $image);
    }

    /**
     * Tests that attempting to draw with an unsupported format
     * produces an exception.
     */
    public function testInvalidFormat()
    {

        $config = $this->createConfigMock();
        $driver = $this->createMock(Driver::class);
        $driver->expects($this->once())
               ->method('canvas')
               ->will($this->returnValue(
                   $this->createMock(Image::class)
               ));

        $this->expectException(InvalidArgumentException::class);

        $drawer = new Drawer($driver);
        $drawer->draw($config);
    }
}
