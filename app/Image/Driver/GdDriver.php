<?php namespace App\Image\Driver;

use App\Image\Image;
use App\Image\Colour;
use App\Image\TrueTypeFont;

/**
 * Driver for the GD library.
 */
class GdDriver implements Driver
{
    /**
     * {@inheritDoc}
     */
    public function canvas($width, $height, Colour $colour)
    {
        $core = imagecreate($width, $height);

        $background = $colour->getRgb();
        imagecolorallocate($core, $background[0], $background[1], $background[2]);

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

        $foreground = $colour->getRgb();
        $colourIdentifier = imagecolorallocate(
            $image->getCore(),
            $foreground[0],
            $foreground[1],
            $foreground[2]
        );

        $imageWidth = imagesx($image->getCore());
        $imageHeight = imagesy($image->getCore());
        $fontSize = min($imageWidth / strlen($text), $imageHeight / 2);

        $textBox = imagettfbbox($fontSize, 0, $font->getPath(), $text);
        $textWidth = ceil($textBox[4] - $textBox[1]);
        $textHeight = ceil(abs($textBox[7]) + abs($textBox[1]));

        imagettftext(
            $image->getCore(),
            $fontSize,
            0,
            ceil(($imageWidth - $textWidth) / 2),
            ceil(($imageHeight - $textHeight) / 2 + $textHeight),
            $colourIdentifier,
            $font->getPath(),
            $text
        );
    }

    /**
     * {@inheritDoc}
     */
    public function encodePng(Image $image)
    {
        $libraryInfo = gd_info();

        if (!$libraryInfo['PNG Support']) {
            throw new InvalidArgumentException('PNG not supported on this system');
        }

        ob_start();
        imagepng($image->getCore());
        $data = ob_get_contents();
        ob_end_clean();

        $image->setData($data);
        $image->setFormat('png');
    }

    /**
     * {@inheritDoc}
     */
    public function encodeGif(Image $image)
    {
        $libraryInfo = gd_info();

        if (!$libraryInfo['GIF Create Support']) {
            throw new InvalidArgumentException('GIF not supported');
        }

        ob_start();
        imagegif($image->getCore());
        $data = ob_get_contents();
        ob_end_clean();

        $image->setData($data);
        $image->setFormat('gif');
    }
}
