<?php namespace App\Image\Config\Build;

use App\Image\Colour;
use App\Image\Config\Config;
use App\Image\Config\Validator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Builds up a random Config instance.
 */
class RandomisedBuilder extends Builder
{
    /**
     * Set a random width based on constraints set by the validator
     * or overridden by the user.
     */
    public function setWidth()
    {
        $minWidth = Validator::MIN_LENGTH;
        $maxWidth = Validator::MAX_LENGTH;

        if ($this->request->query->has('min-width')) {
            $minWidth = $this->request->query->get('min-width');
        }

        if ($this->request->query->has('max-width')) {
            $maxWidth = $this->request->query->get('max-width');
        }

        $this->config->setWidth(rand($minWidth, $maxWidth));
    }

    /**
     * Set a random height based on constraints set by the validator
     * or overridden by the user.
     */
    public function setHeight()
    {
        $minHeight = Validator::MIN_LENGTH;
        $maxHeight = Validator::MAX_LENGTH;

        if ($this->request->query->has('min-height')) {
            $minHeight = $this->request->query->get('min-height');
        }

        if ($this->request->query->has('max-height')) {
            $maxHeight = $this->request->query->get('max-height');
        }

        $this->config->setHeight(rand($minHeight, $maxHeight));
    }

    /**
     * Set a random background colour or attempt to set based on
     * the querystring value.
     */
    public function setBackgroundColour()
    {
        $background = new Colour([
            rand(0, 255),
            rand(0, 255),
            rand(0, 255)
        ]);

        if ($this->request->query->has('bg')) {
            try {
                $background = new Colour($this->request->query->get('bg'));
            } catch (InvalidArgumentException $e) {
                return;
            }
        }

        $this->config->setBackgroundColour($background);
    }

    /**
     * Set a random foreground colour or attempt to set based on
     * the querystring value.
     */
    public function setForegroundColour()
    {
        $foreground = new Colour([
            rand(0, 255),
            rand(0, 255),
            rand(0, 255)
        ]);

        if ($this->request->query->has('fg')) {
            try {
                $foreground = new Colour($this->request->query->get('fg'));
            } catch (InvalidArgumentException $e) {
                return;
            }
        }

        $this->config->setForegroundColour($foreground);
    }
}
