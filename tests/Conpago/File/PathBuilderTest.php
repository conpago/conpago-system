<?php
namespace Conpago\File;

use PHPUnit\Framework\TestCase;

class PathBuilderTest extends TestCase
{
    public function testCreatePath()
    {
        $path = new PathBuilder();
        $this->assertEquals('a'.DIRECTORY_SEPARATOR.'b', $path->createPath(['a', 'b']));
    }

    public function testFileNameWithSlash()
    {
        $path = new PathBuilder();
        $this->assertEquals('a.txt', $path->fileName('b/a.txt'));
    }

    public function testFileNameWithBackslash()
    {
        $path = new PathBuilder();
        $this->assertEquals('a.txt', $path->fileName('b\a.txt'));
    }
}
