<?php namespace App\Image\Config\Build;

use App\Image\Config\Config;
use App\Image\TrueTypeFont;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract class for building an \App\Image\Config\Config.
 */
abstract class Builder
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->config = new Config();
    }

    abstract public function setWidth();

    abstract public function setHeight();

    abstract public function setBackgroundColour();

    abstract public function setForegroundColour();

    /**
     * Set the text based on a querystring key or a default.
     */
    public function setText()
    {
        $text = sprintf(
            '%dx%d',
            $this->config->getWidth(),
            $this->config->getHeight()
        );

        if ($this->request->query->has('text')) {
            $text = $this->request->query->get('text');
        }

        $this->config->setText($text);
    }

    /**
     * Set the font based on a default.
     */
    public function setFont()
    {
        $this->config->setFont(new TrueTypeFont('Roboto-Regular'));
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
     * @return Config
     */
    public function getResult()
    {
        return $this->config;
    }
}
