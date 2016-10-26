<?php namespace Tests\Image\Config\Build;

use App\Image\Config\Config;
use PHPUnit_Framework_TestCase;
use App\Image\Config\Build\Builder;
use App\Image\Config\Build\BuildDirector;

class BuildDirectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests that the director does everything
     * required to correctly configure the Config instance.
     */
    public function testBuild()
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->once())
                ->method('getResult')
                ->will($this->returnValue($this->createMock(Config::class)));

        $builder->expects($this->once())
                ->method('setWidth');

        $builder->expects($this->once())
                ->method('setHeight');

        $builder->expects($this->once())
                ->method('setFormat');

        $builder->expects($this->once())
                ->method('setText');

        $builder->expects($this->once())
                ->method('setFont');

        $builder->expects($this->once())
                ->method('setBackgroundColour');

        $builder->expects($this->once())
                ->method('setForegroundColour');

        $director = new BuildDirector($builder);

        $this->assertInstanceOf(Config::class, $director->getResult());
    }
}
