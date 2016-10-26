<?php namespace App\Image\Driver;

use App\Image\Image;
use App\Image\Colour;
use App\Image\TrueTypeFont;
use InvalidArgumentException;

/**
 * A driver for creating images
 */
interface Driver
{
    /**
     * Create the underlying image and create an Image instance with it.
     *
     * @param int $width
     * @param int $height
     * @param Colour $colour
     *
     * @return Image
     */
    public function canvas($width, $height, Colour $colour);

    /**
     * Write text onto the underlying image.
     *
     * @param Image $image
     * @param string $text
     * @param Colour $colour
     * @param TrueTypeFont $font
     */
    public function writeText(Image $image, $text, Colour $colour, TrueTypeFont $font);

    /**
     * Generate binary data in PNG format from the underlying image
     * and call appropriate setters on the Image instance.
     *
     * @param Image $image
     *
     * @throws InvalidArgumentException unsupported on this system
     */
    public function encodePng(Image $image);

    /**
     * Generate binary data in GIF format from the underlying image
     * and call appropriate setters on the Image instance.
     *
     * @param Image $image
     *
     * @throws InvalidArgumentException unsupported on this system
     */
    public function encodeGif(Image $image);
}
