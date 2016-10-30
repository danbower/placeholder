<?php namespace App\Image\Driver;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use App\Image\Image;
use App\Image\Colour;
use App\Image\TrueTypeFont;

/**
 * Driver for the Imagick library.
 */
class ImagickDriver implements Driver
{
    /**
     * {@inheritDoc}
     */
    public function canvas($width, $height, Colour $colour)
    {
        $background = new ImagickPixel($colour->getHex());
        $core = new Imagick();
        $core->newImage($width, $height, $background);

        return new Image($core);
    }

    /**
     * {@inheritDoc}
     */
    public function writeText(Image $image, $text, Colour $colour, TrueTypeFont $font)
    {
        if (strlen($text) === 0) {
            return;
        }

        $draw = new ImagickDraw();
        $draw->setFillColor($colour->getHex());
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont($font->getPath());

        $imageWidth = $image->getCore()->getImageWidth();
        $imageHeight = $image->getCore()->getImageHeight();
        $fontSize = min($imageWidth / strlen($text), $imageHeight / 2) * 1.31;

        $draw->setFontSize($fontSize);

        $image->getCore()->annotateImage($draw, 0, 0, 0, $text);
    }

    /**
     * {@inheritDoc}
     */
    public function encodePng(Image $image)
    {
        $image->getCore()->setImageFormat('png');

        $image->setFormat('png');
        $image->setData((string) $image->getCore());
    }

    /**
     * {@inheritDoc}
     */
    public function encodeGif(Image $image)
    {
        $image->getCore()->setImageFormat('gif');

        $image->setFormat('gif');
        $image->setData((string) $image->getCore());
    }
}
