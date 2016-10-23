<?php namespace App\Image\Config;

/**
 * Validates Config instances.
 */
class Validator
{
    /**
     * @var int minimum width/height
     */
    const MIN_LENGTH = 1;

    /**
     * @var int maximum width/height
     */
    const MAX_LENGTH = 1920;

    /**
     * @var int maxiumum number of characters
     */
    const MAX_TEXT_LENGTH = 20;

    /**
     * @var string[] valid file formats
     */
    const VALID_FORMATS = ['png', 'gif'];

    /**
     * Validate a configuration.
     *
     * @param Config $config
     *
     * @return array any validation errors
     */
    public function validate(Config $config)
    {
        return array_merge(
            $this->validateDimensions(
                $config->getWidth(),
                $config->getHeight()
            ),
            $this->validateColours(
                $config->getBackgroundColour(),
                $config->getForegroundColour()
            ),
            $this->validateText(
                $config->getText()
            ),
            $this->validateFormat(
                $config->getFormat()
            )
        );
    }

    /**
     * Validate the width and height of the configuration.
     *
     * @param int $width
     * @param int $height
     *
     * @return array any validation errors
     */
    protected function validateDimensions($width, $height)
    {
        $errors = [];

        if ($width < self::MIN_LENGTH) {
            $errors['width'] = sprintf(
                'Width must be greater than or equal to %d',
                self::MIN_LENGTH
            );
        }

        if ($width > self::MAX_LENGTH) {
            $errors['width'] = sprintf(
                'Width must be less than or equal to %d',
                self::MAX_LENGTH
            );
        }

        if ($height < self::MIN_LENGTH) {
            $errors['height'] = sprintf(
                'Height must be greater than or equal to %d',
                self::MIN_LENGTH
            );
        }

        if ($height > self::MAX_LENGTH) {
            $errors['height'] = sprintf(
                'Height must be less than or equal to %d',
                self::MAX_LENGTH
            );
        }

        return $errors;
    }

    /**
     * Validate the background and foreground colours of the configuration.
     *
     * @param string $backgroundColour
     * @param string $foregroundColour
     *
     * @return array any validation errors
     */
    protected function validateColours($backgroundColour, $foregroundColour)
    {
        $errors = [];

        if (!$this->isValidHexColour($backgroundColour)) {
            $errors['backgroundColour'] = 'Background must be a hexadecimal colour';
        }

        if (!$this->isValidHexColour($foregroundColour)) {
            $errors['foregroundColour'] = 'Foreground must be a hexadecimal colour';
        }

        return $errors;
    }

    /**
     * Validate the text of the configuration.
     *
     * @param string $backgroundColour
     * @param string $foregroundColour
     *
     * @return array any validation errors
     */
    protected function validateText($text)
    {
        $errors = [];

        if (strlen($text) > self::MAX_TEXT_LENGTH) {
            $errors['text'] = sprintf(
                'Length of text cannot be greater than %d',
                self::MAX_TEXT_LENGTH
            );
        }

        return $errors;
    }

    /**
     * Validate the file format of the configuration.
     *
     * @param string $format
     *
     * @return array any validation errors
     */
    protected function validateFormat($format)
    {
        $errors = [];

        if (!in_array($format, self::VALID_FORMATS)) {
            $errors['format'] = sprintf(
                'Valid formats are %s',
                implode(', ', self::VALID_FORMATS)
            );
        }

        return $errors;
    }

    /**
     * Determine whether $hex is a hexadecimal colour.
     *
     * @param string $hex
     *
     * @return boolean whether or not it is a hexadecimal colour
     */
    protected function isValidHexColour($hex)
    {
        $hex = preg_replace('/^#/', '', $hex);
        $hexLength = strlen($hex);

        return ($hexLength === 3 || $hexLength === 6) && ctype_xdigit($hex);
    }
}
