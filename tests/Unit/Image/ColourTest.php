<?php namespace Tests\Unit\Image;

use App\Image\Colour;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ColourTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that a hex triplet with a leading hash symbol is deemed valid.
     */
    public function testValidHex()
    {
        $colour = new Colour('#ffffff');

        $this->assertEquals('#ffffff', $colour->getHex());
    }

    /**
     * Tests that a hexadecimal colour wihtout a leading
     * hash symbol is deemed valid.
     */
    public function testHexWithoutHashSymbol()
    {
        $colour = new Colour('ffffff');

        $this->assertEquals('#ffffff', $colour->getHex());
    }

    /**
     * Tests that a string containing non-hex characters is deemed invalid.
     */
    public function testInvalidHexCharacters()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour('#gggggg');
    }

    /**
     * Tests that a hex containing a non-leading hash symbol is deemed invalid.
     */
    public function testHexContainingInvalidHashSymbol()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour('#fff#fff');
    }

    /**
     * Tests that a string containing an invalid number of hex characters
     * is deemed invaid.
     */
    public function testInvalidHexLength()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour('#ffff');
    }

    /**
     * Tests that a shorthand hex is converted to a hex triplet.
     */
    public function testHexPadding()
    {
        $colour = new Colour('#123');

        $this->assertEquals('#112233', $colour->getHex());
    }

    /**
     * Tests that a shorthand hex without a leading hash symbol
     * is converted to a triplet.
     */
    public function testHexPaddingWithoutHash()
    {
        $colour = new Colour('123');

        $this->assertEquals('#112233', $colour->getHex());
    }

    /**
     * Tests that the conversion between hex and RGB produces the
     * correct output.
     */
    public function testHexToRgbConversion()
    {
        $colour = new Colour('#ffffff');

        $this->assertEquals($colour->getRgb(), [255, 255, 255]);
    }

    /**
     * Tests that a standard RGB array is deemed valid.
     */
    public function testValidRgb()
    {
        $colour = new Colour([0, 0, 255]);

        $this->assertEquals($colour->getRgb(), [0, 0, 255]);
    }

    /**
     * Tests that a RGB array containing invalid number ranges
     * is deemed invalid.
     */
    public function testInvalidRgbRange()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour([-1, -1, -1]);
    }

    /**
     * Tests that a RGB array containing non-integers is deemed invalid.
     */
    public function testInvalidRgbCharacters()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour(['aaa', 'aaa', 'aaa']);
    }

    /**
     * Tests that a RGB array containing the invalid number of
     * segements is deemed invalid.
     */
    public function testInvalidRgbSegementAmount()
    {
        $this->expectException(InvalidArgumentException::class);

        new Colour([255, 255]);
    }

    /**
     * Tests that the conversion between RGB and hex produces the
     * correct output.
     */
    public function testRgbToHexConversion()
    {
        $colour = new Colour([255, 255, 255]);

        $this->assertEquals('#ffffff', $colour->getHex());
    }
}
