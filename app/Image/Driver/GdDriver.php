<?php namespace App\Image\Driver;

use App\Image\Image;
use App\Image\Colour;

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
    public function writeText(Image $image, $text, Colour $colour)
    {
        $foreground = $colour->getRgb();
        $colourIdentifier = imagecolorallocate(
            $image->getCore(),
            $foreground[0],
            $foreground[1],
            $foreground[2]
        );

        $font = 4;
        $fontWidth = imagefontwidth($font);
        $fontHeight = imagefontheight($font);
        $textWidth = strlen($text) * $fontWidth;

        imagestring(
            $image->getCore(),
            $font,
            (imagesx($image->getCore()) - $textWidth) / 2,
            (imagesy($image->getCore()) - $fontHeight) / 2,
            $text,
            $colourIdentifier
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
