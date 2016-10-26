<?php namespace App\Image;

use InvalidArgumentException;

/**
 * Wrapper for a TrueType font on the filesystem.
 */
class TrueTypeFont
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name name of the font
     *
     * @throws InvalidArgumentException issue loading the font
     */
    public function __construct($name)
    {
        $this->name = $name;

        $path = $this->getPath();

        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf(
                'Cannot find file at "%s"',
                $path
            ));
        }
    }

    /**
     * Get the full filesystem path to the font.
     *
     * @return string
     */
    public function getPath()
    {
        return sprintf(
            '%s/%s.ttf',
            __DIR__ . '/../../resources/fonts',
            $this->name
        );
    }
}
