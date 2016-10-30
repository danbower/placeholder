<?php namespace App\Image;

use InvalidArgumentException;

class Colour
{
    /**
     * @var string hex triplet with leading hash symbol
     */
    protected $hex;

    /**
     * @var array [R,G,B] format
     */
    protected $rgb;

    /**
     * @param mixed $colour hexadecimal colour or RGB array
     *
     * @throws InvalidArgumentException passed unsupported colour format
     */
    public function __construct($colour)
    {
        switch (true) {
            case is_string($colour) && $this->isValidHex($colour):
                $this->initialiseFromHex($colour);
                break;

            case is_array($colour) && $this->isValidRgb($colour):
                $this->initialiseFromRgb($colour);
                break;

            default:
                throw new InvalidArgumentException(
                    'Only hexadecimal string and RGB array are supported'
                );
        }
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * @return array
     */
    public function getRgb()
    {
        return $this->rgb;
    }

    /**
     * Initialise class properties based on a hexadecimal colour.
     *
     * @param string $colour
     */
    protected function initialiseFromHex($colour)
    {
        if (strpos($colour, '#') === false) {
            $colour = '#' . $colour;
        }

        if (strlen($colour) === 4) {
            $colour = sprintf(
                '#%1$s%1$s%2$s%2$s%3$s%3$s',
                $colour[1],
                $colour[2],
                $colour[3]
            );
        }

        $this->hex = $colour;

        $this->rgb = $this->hexToRgb($colour);
    }

    /**
     * Initialise class properties based on a RGB colour.
     */
    protected function initialiseFromRgb(array $colour)
    {
        $this->hex = $this->rgbToHex($colour);
        $this->rgb = $colour;
    }

    /**
     * Determine whether $hex is a hexadecimal colour.
     *
     * @param string $hex
     *
     * @return boolean
     */
    protected function isValidHex($hex)
    {
        $hex = preg_replace('/^#/', '', $hex);
        $hexLength = strlen($hex);

        return ($hexLength === 3 || $hexLength === 6) && ctype_xdigit($hex);
    }

    /**
     * Convert hex string to RGB array.
     *
     * Hex must be six characters with an optional hash symbol.
     *
     * @param string $hex
     *
     * @return array [R,G,B] format
     */
    protected function hexToRgb($hex)
    {
        return sscanf($hex, '#%02x%02x%02x');
    }

    /**
     * Determine whether $rgb is a RGB colour.
     *
     * @param array $rgb
     *
     * @return boolean
     */
    protected function isValidRgb(array $rgb)
    {
        if (count($rgb) !== 3) {
            return false;
        }

        for ($i = 0; $i < 3; $i++) {
            if ($rgb[$i] < 0 || $rgb[$i] > 255) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert RGB array to hex string.
     *
     * @param array $rgb
     *
     * @return string
     */
    protected function rgbToHex(array $rgb)
    {
        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }
}
