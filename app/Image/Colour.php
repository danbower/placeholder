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
     * @param string $colour hexadecimal colour
     *
     * @throws InvalidArgumentException passed a non-hex colour
     */
    public function __construct($colour)
    {
        if (!$this->isValidHex($colour)) {
            throw new InvalidArgumentException('Only hexadecimal is supported');
        }

        $this->initialiseFromHex($colour);
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
}
