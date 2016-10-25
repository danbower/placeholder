<?php namespace Tests\Image;

use App\Image\Image;
use PHPUnit_Framework_TestCase;

class ImageTest extends PHPUnit_Framework_TestCase
{
    public function testGetMimeType()
    {
        $image = new Image(null);
        $image->setFormat('png');

        $this->assertEquals('image/png', $image->getMimeType());
    }
}
