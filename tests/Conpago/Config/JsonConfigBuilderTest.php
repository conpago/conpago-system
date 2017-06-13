<?php
namespace Conpago\Config;

use \Conpago\File\Contract\IFileSystem;
use PHPUnit\Framework\TestCase;

class JsonConfigBuilderTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $fileSystem;

    /** @var JsonConfigBuilder */
    protected $config;

    public function testConstructorWillSearchForFilesWithDefaultMask()
    {
        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->fileSystem->expects($this->once())
                         ->method("glob")
                         ->with("*.config.json")
                         ->willReturn([]);

        $this->config = new JsonConfigBuilder($this->fileSystem);
        $this->config->build();
    }

    public function testConstructorWillSearchForFilesWithGivenMask()
    {
        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->fileSystem->expects($this->once())
                         ->method("glob")
                         ->with("8")
                         ->willReturn([]);

        $this->config = new JsonConfigBuilder($this->fileSystem, "8");
        $this->config->build();
    }

    public function testLoadOneFileWillAddValuesToConfig()
    {
        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->fileSystem
             ->method("getFileContent")
             ->willReturn('{"a": "b"}');

        $this->fileSystem
                         ->method("glob")
                         ->willReturn(["x"]);

        $this->config = new JsonConfigBuilder($this->fileSystem);
        $this->assertEquals(["a" => "b"], $this->config->build());
    }

    public function testLoadTwoFilesWillAppendValuesFromSecondFileToConfig()
    {
        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->fileSystem
                         ->method("getFileContent")
                         ->withConsecutive(["x"], ["y"])
                         ->willReturnOnConsecutiveCalls(
                             '{"a": "b"}',
                             '{"c": "d"}'
                         );
        $this->fileSystem
                         ->method("glob")
                         ->willReturn(["x", "y"]);

        $this->config = new JsonConfigBuilder($this->fileSystem);
        $this->assertEquals(["a" => "b", "c" => "d"], $this->config->build());
    }

    public function testLoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
    {
        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->fileSystem
                         ->method("getFileContent")
                         ->withConsecutive(["x"], ["y"])
                         ->willReturnOnConsecutiveCalls(
                                 '{"c": "d"}',
                                 '{"c": "b"}'
                         );
        $this->fileSystem
                         ->method("glob")
                         ->willReturn(["x", "y"]);

        $this->config = new JsonConfigBuilder($this->fileSystem);
        $this->assertEquals(["c" => "b"], $this->config->build());
    }
}
