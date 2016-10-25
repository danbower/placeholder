<?php namespace Tests\Unit\Image\Config;

use App\Image\Colour;
use App\Image\Config\Config;
use App\Image\Config\Validator;
use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that valid dimensions don't produce validation errors.
     */
    public function testValidDimensions()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getWidth')
                      ->will($this->returnValue(200));

        $configuration->expects($this->once())
                      ->method('getHeight')
                      ->will($this->returnValue(200));

        $errors = $validator->validate($configuration);

        $this->assertArrayNotHasKey('width', $errors);
        $this->assertArrayNotHasKey('height', $errors);
    }

    /**
     * Tests that empty dimensions produce validation errors.
     */
    public function testEmptyDimensions()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getWidth')
                      ->will($this->returnValue(null));

        $configuration->expects($this->once())
                      ->method('getHeight')
                      ->will($this->returnValue(null));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('width', $errors);
        $this->assertArrayHasKey('height', $errors);
    }

    /**
     * Tests that small widths and heights produce validation errors.
     */
    public function testTooSmallDimensions()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getWidth')
                      ->will($this->returnValue(0));

        $configuration->expects($this->once())
                      ->method('getHeight')
                      ->will($this->returnValue(0));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('width', $errors);
        $this->assertArrayHasKey('height', $errors);
    }

    /**
     * Tests that large width and heights produce validation errors.
     */
    public function testTooBigDimensions()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getWidth')
                      ->will($this->returnValue(99999));

        $configuration->expects($this->once())
                      ->method('getHeight')
                      ->will($this->returnValue(99999));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('width', $errors);
        $this->assertArrayHasKey('height', $errors);
    }

    /**
     * Tests that valid background and foreground colours
     * don't produce validation errors.
     */
    public function testValidColours()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getBackgroundColour')
                      ->will($this->returnValue(
                          $this->createMock(Colour::class)
                      ));

        $configuration->expects($this->once())
                      ->method('getForegroundColour')
                      ->will($this->returnValue(
                          $this->createMock(Colour::class)
                      ));

        $errors = $validator->validate($configuration);

        $this->assertArrayNotHasKey('backgroundColour', $errors);
        $this->assertArrayNotHasKey('foregroundColour', $errors);
    }

    /**
     *  Tests that empty colours produce validation errors.
     */
    public function testEmptyColours()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getBackgroundColour')
                      ->will($this->returnValue(null));

        $configuration->expects($this->once())
                      ->method('getForegroundColour')
                      ->will($this->returnValue(null));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('backgroundColour', $errors);
        $this->assertArrayHasKey('foregroundColour', $errors);
    }

    /**
     * Tests that a valid file format doesn't produce a validation error.
     */
    public function testValidFormat()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getFormat')
                      ->will($this->returnValue('png'));

        $errors = $validator->validate($configuration);

        $this->assertArrayNotHasKey('format', $errors);
    }

    /**
     * Tests that an unrecognised file format produces a validation error.
     */
    public function testUnknownFormat()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getFormat')
                      ->will($this->returnValue('foo'));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('format', $errors);
    }

    /**
     * Tests that valid text doesn't produce a validation error.
     */
    public function testValidText()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getText')
                      ->will($this->returnValue('foo bar'));

        $errors = $validator->validate($configuration);

        $this->assertArrayNotHasKey('text', $errors);
    }

    /**
     * Tests that long text produces a validation error.
     */
    public function testTooLongText()
    {
        $validator = new Validator();
        $configuration = $this->createMock(Config::class);
        $configuration->expects($this->once())
                      ->method('getText')
                      ->will($this->returnValue(substr(md5(rand()), 0, 21)));

        $errors = $validator->validate($configuration);

        $this->assertArrayHasKey('text', $errors);
    }
}
