<?php namespace App\Image\Config\Build;

/**
 * Oversees the creation of an \App\Image\Config\Config instance.
 */
class BuildDirector
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;

        $this->builder->setWidth();
        $this->builder->setHeight();
        $this->builder->setFormat();
        $this->builder->setText();
        $this->builder->setFont();
        $this->builder->setBackgroundColour();
        $this->builder->setForegroundColour();
    }

    /**
     * @return \App\Image\Config\Config
     */
    public function getResult()
    {
        return $this->builder->getResult();
    }
}
