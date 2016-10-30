<?php namespace App\Image\Config\Build;

use App\Image\Colour;
use App\Image\Config\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Builds up a Config instance based on properties of a Request.
 */
class StandardBuilder extends Builder
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
     * @param int $width
     * @param int $height
     * @param Request $request
     */
    public function __construct($width, $height, Request $request)
    {
        parent::__construct($request);

        $this->width = $width;
        $this->height = $height;
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
     * Set the background colour based on a default or attempt to update
     * based on the querystring value.
     */
    public function setBackgroundColour()
    {
        $background = new Colour('#000000');

        if ($this->request->query->has('bg')) {
            try {
                $background = new Colour($this->request->query->get('bg'));
            } catch (InvalidArgumentException $e) {
                return;
            }
        }

        $this->config->setBackgroundColour($background);
    }

    /**
     * Set the foreground colour based on a default or attempt to update
     * based on the querystring value.
     */
    public function setForegroundColour()
    {
        $foreground = new Colour('#ffffff');

        if ($this->request->query->has('fg')) {
            try {
                $foreground = new Colour($this->request->query->get('fg'));
            } catch (InvalidArgumentException $e) {
                return;
            }
        }

        $this->config->setForegroundColour($foreground);
    }
}
