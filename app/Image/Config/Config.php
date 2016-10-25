<?php namespace App\Image\Config;

use App\Image\Colour;

/**
 * A configuration of an image containing some text.
 */
class Config
{
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var Colour
     */
    protected $backgroundColour;

    /**
     * @var Colour
     */
    protected $foregroundColour;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return Colour
     */
    public function getBackgroundColour()
    {
        return $this->backgroundColour;
    }

    /**
     * @param Colour $backgroundColour
     */
    public function setBackgroundColour(Colour $backgroundColour)
    {
        $this->backgroundColour = $backgroundColour;
    }

    /**
     * @return Colour
     */
    public function getForegroundColour()
    {
        return $this->foregroundColour;
    }

    /**
     * @param Colour $foregroundColour
     */
    public function setForegroundColour(Colour $foregroundColour)
    {
        $this->foregroundColour = $foregroundColour;
    }
}
