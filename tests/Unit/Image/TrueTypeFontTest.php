<?php namespace Tests\Unit\Image;

use App\Image\TrueTypeFont;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class TrueTypeFontTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that an unknown font name throws an exception.
     */
    public function testUnknownFontName()
    {
        $this->expectException(InvalidArgumentException::class);

        new TrueTypeFont('foo');
    }

    /**
     * Tests that the path produced contains the correct extension
     * and points to an actual file.
     */
    public function testPath()
    {
        $font = new TrueTypeFont('Roboto-Regular');

        $this->assertRegexp('/.+\/Roboto-Regular.ttf$/', $font->getPath());
        $this->assertTrue(file_exists($font->getPath()));
    }
}
