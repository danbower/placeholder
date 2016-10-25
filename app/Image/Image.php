<?php namespace App\Image;

/**
 * Wrapper class for GD image resources and objects (e.g. Imagick instances)
 */
class Image
{
    /**
     * The underlying image
     *
     * @var resource|object
     */
    protected $core;

    /**
     * Binary data of the image
     *
     * @var string
     */
    protected $data;

    /**
     * Format of the binary data
     */
    protected $format;

    /**
     * @param resource|object $core
     */
    public function __construct($core)
    {
        $this->core = $core;
    }

    /**
     * @return resource|object
     */
    public function getCore()
    {
        return $this->core;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format();
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
    public function getMimeType()
    {
        return 'image/' . $this->format;
    }
}
