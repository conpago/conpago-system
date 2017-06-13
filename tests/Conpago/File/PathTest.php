<?php
namespace Conpago\File;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testGetRealPath()
    {
        $path = new Path("a", "");
        $this->assertEquals('a', $path->get());
    }

    public function testGetPath()
    {
        $path = new Path("", "a/b/c");
        $this->assertEquals('a/b/c', $path->getReal());
    }
}
