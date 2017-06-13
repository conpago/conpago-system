<?php
namespace Conpago\Config;

use Conpago\File\Contract\IFileSystem;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class PhpConfigBuilderTest extends TestCase
{
    /** @var IFileSystem | MockObject */
    protected $fileSystem;

    /** @var PhpConfigBuilder */
    protected $config;

    public function testConstructorWillSearchForFilesWithDefaultMask()
    {
        $this->fileSystem = $this->createFileSystemMock();

        $this->fileSystem
            ->expects($this->once())
            ->method("glob")
            ->with("*.config.php")
            ->willReturn([]);

        $this->config = new PhpConfigBuilder($this->fileSystem);
        $this->config->build();
    }

    public function testConstructorWillSearchForFilesWithGivenMask()
    {
        $this->fileSystem = $this->createFileSystemMock();

        $this->fileSystem
            ->expects($this->once())
            ->method("glob")
            ->with("8")
            ->willReturn([]);

        $this->config = new PhpConfigBuilder($this->fileSystem, "8");
        $this->config->build();
    }

    public function testLoadOneFileWillAddValuesToConfig()
    {
        $this->fileSystem = $this->createFileSystemMock();

        $this->fileSystem
            ->method("includeFile")
            ->willReturn(["a" => "b"]);

        $this->fileSystem
            ->method("glob")
            ->willReturn(["x"]);

        $this->config = new PhpConfigBuilder($this->fileSystem);
        $this->assertEquals(["a" => "b"], $this->config->build());
    }

    public function testLoadTwoFilesWillAppendValuesFromSecondFileToConfig()
    {
        $this->fileSystem = $this->createFileSystemMock();

        $this->fileSystem
             ->method("includeFile")
            ->withConsecutive(["x"], ["y"])
            ->willReturnOnConsecutiveCalls(
                ["a" => "b"],
                ["c" => "d"]
            );
        $this->fileSystem
            ->method("glob")
            ->willReturn(["x", "y"]);

        $this->config = new PhpConfigBuilder($this->fileSystem);
        $this->assertEquals(["a" => "b", "c" => "d"], $this->config->build());
    }

    public function testLoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
    {
        $this->fileSystem = $this->createFileSystemMock();

        $this->fileSystem
            ->method("includeFile")
            ->withConsecutive(["x"], ["y"])
            ->willReturnOnConsecutiveCalls(
                ["c" => "d"],
                ["c" => "b"]
            );
        $this->fileSystem
            ->method("glob")
            ->willReturn(["x", "y"]);

        $this->config = new PhpConfigBuilder($this->fileSystem);
        $this->assertEquals(["c" => "b"], $this->config->build());
    }

    /**
     * @return IFileSystem | MockObject
     */
    public function createFileSystemMock()
    {
        return $this->createMock(IFileSystem::class);
    }
}
