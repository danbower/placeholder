<?php namespace App\Image\Config;

/**
 * A configuration of an image containing some text.
 */
class Config
{
    /**
     * Initialised within the constructor
     *
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $width = 200;

    /**
     * @var int
     */
    protected $height = 200;

    /**
     * @var string
     */
    protected $format = 'png';

    /**
     * @var string
     */
    protected $backgroundColour = '000';

    /**
     * @var string
     */
    protected $foregroundColour = 'fff';

    public function __construct()
    {
        $this->text = sprintf('%dx%d', $this->width, $this->height);
    }

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
     * @return string
     */
    public function getBackgroundColour()
    {
        return $this->backgroundColour;
    }

    /**
     * @param string $backgroundColour
     */
    public function setBackgroundColour($backgroundColour)
    {
        $this->backgroundColour = $backgroundColour;
    }

    /**
     * @return string
     */
    public function getForegroundColour()
    {
        return $this->foregroundColour;
    }

    /**
     * @param string $foregroundColour
     */
    public function setForegroundColour($foregroundColour)
    {
        $this->foregroundColour = $foregroundColour;
    }
}
