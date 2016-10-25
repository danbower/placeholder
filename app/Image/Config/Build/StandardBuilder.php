<?php namespace App\Image\Config\Build;

use App\Image\Config\Config;
use Symfony\Component\HttpFoundation\Request;

/**
 * Builds up a Config instance based on properties of a Request.
 */
class StandardBuilder implements Builder
{
    /**
     * @var string
     */
    protected $width;

    /**
     * @var string
     */
    protected $height;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param int $width
     * @param int $height
     * @param Request $request
     */
    public function __construct($width, $height, Request $request)
    {
        $this->width = $width;
        $this->height = $height;
        $this->request = $request;

        $this->config = new Config();
    }

    /**
     * @return Config
     */
    public function getResult()
    {
        return $this->config;
    }

    /**
     * Set the width based on class property.
     */
    public function setWidth()
    {
        $this->config->setWidth($this->width);
    }

    /**
     * Set the height based on class property.
     */
    public function setHeight()
    {
        $this->config->setHeight($this->height);
    }

    /**
     * Set the file format based on the "format" found in the route.
     *
     * This assumes the Request has been handled by the Symfony
     * routing component.
     */
    public function setFormat()
    {
        $this->config->setFormat($this->request->attributes->get('format'));
    }

    /**
     * Set the text based on a querystring key or a default.
     */
    public function setText()
    {
        $text = sprintf('%dx%d', $this->width, $this->height);

        if ($this->request->query->has('text')) {
            $text = $this->request->query->get('text');
        }

        $this->config->setText($text);
    }

    /**
     * Set the background colour based on a querystring key or a default.
     */
    public function setBackgroundColour()
    {
        $background = '#000000';

        if ($this->request->query->has('bg')) {
            $background = $this->request->query->get('bg');
        }

        $this->config->setBackgroundColour($background);
    }

    /**
     * Set the foreground colour based on a querystring key or a default.
     */
    public function setForegroundColour()
    {
        $foreground = '#ffffff';

        if ($this->request->query->has('fg')) {
            $foreground = $this->request->query->get('fg');
        }

        $this->config->setForegroundColour($foreground);
    }
}
