<?php namespace App\Image\Config\Build;

/**
 * The interface for building an \App\Image\Config\Config.
 */
interface Builder
{
    public function setWidth();

    public function setHeight();

    public function setText();

    public function setFormat();

    public function setBackgroundColour();

    public function setForegroundColour();

    public function getResult();
}
