<?php namespace App\Image;

use App\Image\Config\Config;
use App\Image\Driver\Driver;
use InvalidArgumentException;

/**
 * Produces an image based on some configuration.
 */
class Drawer
{
    /**
     * @var Driver $driver
     */
    protected $driver;

    /**
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param Config $config
     *
     * @return Image
     */
    public function draw(Config $config)
    {
        $image = $this->driver->canvas(
            $config->getWidth(),
            $config->getHeight(),
            $config->getBackgroundColour()
        );

        $this->driver->writeText(
            $image,
            $config->getText(),
            $config->getForegroundColour(),
            $config->getFont()
        );

        switch ($config->getFormat()) {
            case 'png':
                $this->driver->encodePng($image);
                break;

            case 'gif':
                $this->driver->encodeGif($image);
                break;

            default:
                throw new InvalidArgumentException('Passed invalid config');
        }

        return $image;
    }
}
